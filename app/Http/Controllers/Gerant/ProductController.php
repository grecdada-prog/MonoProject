<?php

namespace App\Http\Controllers\Gerant;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Filtrer produits par store_id si le gérant a un magasin assigné
        $products = Product::query()
            ->when($user->store_id, function($q) use ($user) {
                $q->where('store_id', $user->store_id);
            })
            ->orderBy('name')
            ->paginate(50);

        return view('gerant.products.index', compact('products'));
    }

    public function create()
    {
        return view('gerant.products.create');
    }

public function store(Request $request)
{
    $request->validate([
        'name'                  => 'required',
        'sku'                   => 'required|unique:products',
        'purchase_price'        => 'required|numeric|min:0',
        'sale_price'            => 'required|numeric|min:0',
        'current_stock'         => 'required|integer|min:0',
        'stock_alert_threshold' => 'required|integer|min:0',
    ]);

    DB::transaction(function () use ($request) {
        $user = auth()->user();

        $product = Product::create([
            'name'                  => $request->name,
            'slug'                  => Str::slug($request->name) . '-' . Str::random(4),
            'sku'                   => $request->sku,
            'barcode'               => $request->barcode,
            'description'           => $request->description,
            'purchase_price'        => $request->purchase_price,
            'sale_price'            => $request->sale_price,
            'current_stock'         => $request->current_stock,
            'stock_alert_threshold' => $request->stock_alert_threshold,
            'store_id'              => $user->store_id, // Lier au magasin du gérant
            'is_active'             => true,
        ]);

        StockMovement::create([
            'product_id'     => $product->id,
            'user_id'        => Auth::id(),
            'sale_id'        => null,
            'type'           => 'IN',
            'quantity'       => $request->current_stock,
            'previous_stock' => 0,
            'new_stock'      => $request->current_stock,
            'reason'         => 'Stock initial',
        ]);

        // broadcast temps réel après création du produit + mouvement
        event(new \App\Events\StockUpdated($product));
    });

    return redirect()->route('gerant.products.index')
        ->with('success', 'Produit créé avec succès.');
}


    public function edit(Product $product)
    {
        return view('gerant.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'                 => 'required',
            'sku'                  => 'required|unique:products,sku,' . $product->id,
            'purchase_price'       => 'required|numeric|min:0',
            'sale_price'           => 'required|numeric|min:0',
            'stock_alert_threshold'=> 'required|integer|min:0',
        ]);

        $product->update([
            'name'                 => $request->name,
            'sku'                  => $request->sku,
            'barcode'              => $request->barcode,
            'description'          => $request->description,
            'purchase_price'       => $request->purchase_price,
            'sale_price'           => $request->sale_price,
            'stock_alert_threshold'=> $request->stock_alert_threshold,
            'is_active'            => $request->has('is_active'),
        ]);

        return redirect()->route('gerant.products.index')
            ->with('success', 'Produit mis à jour.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return back()->with('success', 'Produit supprimé.');
    }

    public function adjustStock(Request $request, Product $product)
    {
        $request->validate([
            'type'     => 'required|in:IN,OUT,ADJUSTMENT',
            'quantity' => 'required|integer|min:1',
            'reason'   => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $product) {
            $previous = $product->current_stock;
            $new      = $previous;

            if ($request->type === 'IN') {
                $new += $request->quantity;
            } elseif ($request->type === 'OUT') {
                $new -= $request->quantity;
            } else { // ADJUSTMENT
                $new = $request->quantity;
            }

            $product->update(['current_stock' => $new]);

            StockMovement::create([
                'product_id'    => $product->id,
                'user_id'       => Auth::id(),
                'sale_id'       => null,
                'type'          => $request->type,
                'quantity'      => $request->quantity,
                'previous_stock'=> $previous,
                'new_stock'     => $new,
                'reason'        => $request->reason,
            ]);
        });

        event(new \App\Events\StockUpdated($product));


        return back()->with('success', 'Stock ajusté.');
    }

    public function lowStockWidget()
    {
        $products = Product::whereColumn('current_stock', '<=', 'stock_alert_threshold')
            ->orderBy('current_stock')
            ->limit(10)
            ->get();

        return view('gerant.products.partials.low-stock-widget', compact('products'));
    }
}
