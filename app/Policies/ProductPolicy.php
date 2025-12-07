<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    /**
     * Determine if the user can view any products.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['super-admin', 'gerant', 'vendeur']);
    }

    /**
     * Determine if the user can view the product.
     */
    public function view(User $user, Product $product): bool
    {
        // Super-admin: peut voir tous les produits
        if ($user->hasRole('super-admin')) {
            return true;
        }

        // Gérant/Vendeur: seulement si même magasin (ou pas de magasin assigné)
        if ($user->store_id) {
            return $product->store_id === $user->store_id;
        }

        return true;
    }

    /**
     * Determine if the user can create products.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole(['super-admin', 'gerant']);
    }

    /**
     * Determine if the user can update the product.
     */
    public function update(User $user, Product $product): bool
    {
        // Super-admin: peut modifier tous les produits
        if ($user->hasRole('super-admin')) {
            return true;
        }

        // Gérant: seulement si même magasin
        if ($user->hasRole('gerant')) {
            if ($user->store_id) {
                return $product->store_id === $user->store_id;
            }
            return true;
        }

        return false;
    }

    /**
     * Determine if the user can delete the product.
     */
    public function delete(User $user, Product $product): bool
    {
        // Super-admin: peut supprimer tous les produits
        if ($user->hasRole('super-admin')) {
            return true;
        }

        // Gérant: seulement si même magasin
        if ($user->hasRole('gerant')) {
            if ($user->store_id) {
                return $product->store_id === $user->store_id;
            }
            return true;
        }

        return false;
    }

    /**
     * Determine if the user can sell the product.
     */
    public function sell(User $user, Product $product): bool
    {
        // Vendeur et Gérant peuvent vendre
        if (!$user->hasAnyRole(['vendeur', 'gerant'])) {
            return false;
        }

        // Vérifier isolation par magasin
        if ($user->store_id) {
            return $product->store_id === $user->store_id;
        }

        return true;
    }
}
