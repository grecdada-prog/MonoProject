<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Store;
use App\Models\UserSession;

class DashboardController extends Controller
{
    public function index()
    {
        // Stats utilisateurs globaux
        $totalUsers = User::count();
        $totalGerants = User::role('gerant')->count();
        $totalVendeurs = User::role('vendeur')->count();
        $activeUsers = UserSession::where('is_active', true)->count();

        // Stats magasins
        $totalStores = Store::count();
        $activeStores = Store::where('is_active', true)->count();

        // Stats produits & ventes
        $lowStock = Product::whereColumn('current_stock', '<=', 'stock_alert_threshold')->count();
        $todaySales = Sale::whereDate('sold_at', today())->count();
        $todayRevenue = Sale::whereDate('sold_at', today())->sum('total_amount');

        // Stats par magasin (top 5)
        $storeStats = Store::withCount(['managers', 'users'])
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($store) {
                $stats = $store->stats();
                return [
                    'id' => $store->id,
                    'name' => $store->name,
                    'code' => $store->code,
                    'managers_count' => $store->managers_count,
                    'users_count' => $store->users_count,
                    'total_sales' => $stats['total_sales'],
                    'total_revenue' => $stats['total_revenue'],
                    'total_profit' => $stats['total_profit'],
                ];
            });

        return view('superadmin.dashboard', compact(
            'totalUsers',
            'totalGerants',
            'totalVendeurs',
            'activeUsers',
            'totalStores',
            'activeStores',
            'lowStock',
            'todaySales',
            'todayRevenue',
            'storeStats'
        ));
    }
}
