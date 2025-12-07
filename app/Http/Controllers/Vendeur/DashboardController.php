<?php

namespace App\Http\Controllers\Vendeur;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $todaySales = Sale::where('seller_id', $user->id)
            ->whereDate('sold_at', today());

        $totalSalesToday = $todaySales->count();
        $revenueToday    = $todaySales->sum('total_amount');

        $totalSales = Sale::where('seller_id', $user->id)->count();
        $totalRevenue = Sale::where('seller_id', $user->id)->sum('total_amount');

        $avgTicket = $totalSalesToday > 0
            ? $revenueToday / $totalSalesToday
            : 0;

        return view('vendeur.dashboard', [
            'totalSalesToday' => $totalSalesToday,
            'revenueToday'    => $revenueToday,
            'avgTicket'       => $avgTicket,
            'totalSales'      => $totalSales,
            'totalRevenue'    => $totalRevenue,
        ]);
    }

    public function lastInvoicePdf()
{
    $sale = Sale::where('seller_id', Auth::id())
        ->latest('sold_at')
        ->first();

    if (!$sale) {
        return back()->with('error', 'Aucune vente disponible.');
    }

    return redirect()->route('vendeur.sales.invoicePdf', $sale->id);
}
}
