<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Store extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'address',
        'city',
        'phone',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Un magasin a plusieurs gérants
     */
    public function managers()
    {
        return $this->hasMany(User::class, 'store_id')->role('gerant');
    }

    /**
     * Un magasin a plusieurs utilisateurs (gérants + vendeurs)
     */
    public function users()
    {
        return $this->hasMany(User::class, 'store_id');
    }

    /**
     * Tous les vendeurs du magasin (via les gérants)
     */
    public function sellers()
    {
        $managerIds = $this->managers()->pluck('id');
        return User::whereIn('manager_id', $managerIds)->role('vendeur');
    }

    /**
     * Toutes les ventes du magasin
     */
    public function sales()
    {
        $sellerIds = $this->sellers()->pluck('id');
        return Sale::whereIn('seller_id', $sellerIds);
    }

    /**
     * Statistiques du magasin (avec cache Redis 5 minutes)
     */
    public function stats()
    {
        $cacheKey = "store.{$this->id}.stats";

        return Cache::remember($cacheKey, now()->addMinutes(5), function () {
            // Récupérer les IDs des gérants et vendeurs en une seule query
            $managerIds = $this->managers()->pluck('id');

            if ($managerIds->isEmpty()) {
                return [
                    'total_sales' => 0,
                    'total_revenue' => 0,
                    'total_profit' => 0,
                    'active_managers' => 0,
                    'total_sellers' => 0,
                    'active_sellers' => 0,
                ];
            }

            $sellerIds = User::whereIn('manager_id', $managerIds)
                ->role('vendeur')
                ->pluck('id');

            // Agrégation SQL optimisée pour les ventes
            $salesStats = DB::table('sales')
                ->whereIn('seller_id', $sellerIds)
                ->selectRaw('COUNT(*) as total_sales, SUM(total_amount) as total_revenue, SUM(profit) as total_profit')
                ->first();

            // Compteurs utilisateurs optimisés
            $managersCount = $this->managers()->where('is_active', true)->count();
            $sellersStats = User::whereIn('manager_id', $managerIds)
                ->role('vendeur')
                ->selectRaw('COUNT(*) as total, SUM(CASE WHEN is_active = true THEN 1 ELSE 0 END) as active')
                ->first();

            return [
                'total_sales' => (int) ($salesStats->total_sales ?? 0),
                'total_revenue' => (float) ($salesStats->total_revenue ?? 0),
                'total_profit' => (float) ($salesStats->total_profit ?? 0),
                'active_managers' => $managersCount,
                'total_sellers' => (int) ($sellersStats->total ?? 0),
                'active_sellers' => (int) ($sellersStats->active ?? 0),
            ];
        });
    }

    /**
     * Invalider le cache des statistiques
     */
    public function clearStatsCache(): void
    {
        Cache::forget("store.{$this->id}.stats");
    }
}
