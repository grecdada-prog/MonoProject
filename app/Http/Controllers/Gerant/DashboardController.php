<?php

namespace App\Http\Controllers\Gerant;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use App\Models\UserSession;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $manager = Auth::user();

        // Sous-requête pour les vendeurs du gérant
        $vendeursQuery = User::role('vendeur')
            ->where('manager_id', $manager->id)
            ->select('id');

        // Statistiques des ventes du jour avec sous-requête optimisée
        $todaySalesStats = Sale::whereIn('seller_id', $vendeursQuery)
            ->whereDate('sold_at', today())
            ->selectRaw('COUNT(*) as total_sales, SUM(total_amount) as revenue, SUM(profit) as profit')
            ->first();

        $totalVendeurs = User::role('vendeur')
            ->where('manager_id', $manager->id)
            ->count();

        $activeVendeurs = UserSession::whereIn('user_id', $vendeursQuery)
            ->where('is_active', true)
            ->distinct('user_id')
            ->count('user_id');

        $lowStockCount = Product::whereColumn('current_stock', '<=', 'stock_alert_threshold')->count();

        return view('gerant.dashboard', [
            'totalVendeurs'  => $totalVendeurs,
            'totalSalesToday'=> $todaySalesStats->total_sales ?? 0,
            'revenueToday'   => $todaySalesStats->revenue ?? 0,
            'profitToday'    => $todaySalesStats->profit ?? 0,
            'activeVendeurs' => $activeVendeurs,
            'lowStockCount'  => $lowStockCount,
        ]);
    }
}
