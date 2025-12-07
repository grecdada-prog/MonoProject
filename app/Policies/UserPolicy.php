<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine if the user can view any users.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['super-admin', 'gerant']);
    }

    /**
     * Determine if the user can view the user.
     */
    public function view(User $user, User $model): bool
    {
        // Super-admin: peut voir tous les utilisateurs
        if ($user->hasRole('super-admin')) {
            return true;
        }

        // Gérant: peut voir ses vendeurs + lui-même
        if ($user->hasRole('gerant')) {
            return $model->id === $user->id || $model->manager_id === $user->id;
        }

        // Tout utilisateur peut voir son propre profil
        return $user->id === $model->id;
    }

    /**
     * Determine if the user can create users.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole(['super-admin', 'gerant']);
    }

    /**
     * Determine if the user can update the user.
     */
    public function update(User $user, User $model): bool
    {
        // Personne ne peut se modifier soi-même (sauf profil via ProfileController)
        if ($user->id === $model->id) {
            return false;
        }

        // Super-admin: peut modifier tous les utilisateurs (sauf lui-même)
        if ($user->hasRole('super-admin')) {
            return true;
        }

        // Gérant: seulement ses vendeurs
        if ($user->hasRole('gerant')) {
            return $model->manager_id === $user->id && $model->hasRole('vendeur');
        }

        return false;
    }

    /**
     * Determine if the user can delete the user.
     */
    public function delete(User $user, User $model): bool
    {
        // Ne peut pas se supprimer soi-même
        if ($user->id === $model->id) {
            return false;
        }

        // Super-admin: peut supprimer tous sauf lui-même
        if ($user->hasRole('super-admin')) {
            return true;
        }

        // Gérant: seulement ses vendeurs
        if ($user->hasRole('gerant')) {
            return $model->manager_id === $user->id && $model->hasRole('vendeur');
        }

        return false;
    }

    /**
     * Determine if the user can toggle status.
     */
    public function toggleStatus(User $user, User $model): bool
    {
        // Même logique que update
        return $this->update($user, $model);
    }

    /**
     * Determine if the user can force logout.
     */
    public function forceLogout(User $user, User $model): bool
    {
        // Super-admin uniquement (et pas sur soi-même)
        if (!$user->hasRole('super-admin')) {
            return false;
        }

        return $user->id !== $model->id;
    }
}
