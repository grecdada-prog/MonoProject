<?php

namespace App\Policies;

use App\Models\Sale;
use App\Models\User;

class SalePolicy
{
    /**
     * Determine if the user can view any sales.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['super-admin', 'gerant', 'vendeur']);
    }

    /**
     * Determine if the user can view the sale.
     */
    public function view(User $user, Sale $sale): bool
    {
        // Super-admin: peut voir toutes les ventes
        if ($user->hasRole('super-admin')) {
            return true;
        }

        // Gérant: peut voir les ventes de ses vendeurs
        if ($user->hasRole('gerant')) {
            return $sale->manager_id === $user->id || $sale->seller_id === $user->id;
        }

        // Vendeur: seulement ses propres ventes
        if ($user->hasRole('vendeur')) {
            return $sale->seller_id === $user->id;
        }

        return false;
    }

    /**
     * Determine if the user can create sales.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole(['vendeur', 'gerant']);
    }

    /**
     * Determine if the user can update the sale.
     */
    public function update(User $user, Sale $sale): bool
    {
        // Les ventes complétées ne peuvent pas être modifiées
        if ($sale->status === 'COMPLETED') {
            return false;
        }

        // Super-admin peut modifier (cas exceptionnel)
        if ($user->hasRole('super-admin')) {
            return true;
        }

        // Gérant peut modifier les ventes de ses vendeurs
        if ($user->hasRole('gerant')) {
            return $sale->manager_id === $user->id;
        }

        return false;
    }

    /**
     * Determine if the user can delete the sale.
     */
    public function delete(User $user, Sale $sale): bool
    {
        // Super-admin uniquement (avec restrictions métier)
        return $user->hasRole('super-admin');
    }

    /**
     * Determine if the user can download invoice.
     */
    public function downloadInvoice(User $user, Sale $sale): bool
    {
        // Super-admin: toutes les factures
        if ($user->hasRole('super-admin')) {
            return true;
        }

        // Gérant: factures de ses vendeurs
        if ($user->hasRole('gerant')) {
            return $sale->manager_id === $user->id || $sale->seller_id === $user->id;
        }

        // Vendeur: ses propres factures uniquement
        if ($user->hasRole('vendeur')) {
            return $sale->seller_id === $user->id;
        }

        return false;
    }
}
