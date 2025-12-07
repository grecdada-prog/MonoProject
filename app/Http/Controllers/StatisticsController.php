<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Facades\Auth;

class StatisticsController extends Controller
{
    public function sales7days()
    {
        $user = Auth::user();

        $sales = Sale::where('seller_id', $user->id)
            ->where('sold_at', '>=', now()->subDays(7))
            ->selectRaw('DATE(sold_at) as d, SUM(total_amount) as total')
            ->groupBy('d')
            ->orderBy('d')
            ->get();

        return response()->json($sales);
    }

    public function topProducts()
    {
        $user = Auth::user();

        $items = SaleItem::whereHas('sale', function ($q) use ($user) {
                $q->where('seller_id', $user->id);
            })
            ->selectRaw('product_id, SUM(quantity) as qty')
            ->groupBy('product_id')
            ->orderByDesc('qty')
            ->limit(5)
            ->with('product')
            ->get();

        return response()->json($items);
    }
}
