<?php

namespace App\Http\Controllers\Gerant;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockSupplyController extends Controller
{
    /**
     * Liste des approvisionnements
     */
    public function index()
    {
        $user = auth()->user();

        // Récupérer tous les mouvements d'approvisionnement (type IN)
        // Filtrage par user_id pour l'instant (en attendant que products ait store_id partout)
        $supplies = StockMovement::where('type', 'IN')
            ->with(['product', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        // Stats
        $totalSupplies = $supplies->total();
        $todaySupplies = StockMovement::where('type', 'IN')
            ->whereDate('created_at', today())
            ->count();

        $monthSupplies = StockMovement::where('type', 'IN')
            ->whereMonth('created_at', now()->month)
            ->count();

        return view('gerant.supplies.index', compact('supplies', 'totalSupplies', 'todaySupplies', 'monthSupplies'));
    }

    /**
     * Formulaire nouvel approvisionnement
     */
    public function create()
    {
        $user = auth()->user();

        // Récupérer les produits du magasin du gérant (si store_id disponible)
        $products = Product::where('is_active', true)
            ->when($user->store_id, function($q) use ($user) {
                $q->where('store_id', $user->store_id);
            })
            ->orderBy('name')
            ->get();

        return view('gerant.supplies.create', compact('products'));
    }

    /**
     * Enregistrer approvisionnement
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplies' => 'required|array|min:1',
            'supplies.*.product_id' => 'required|exists:products,id',
            'supplies.*.quantity' => 'required|integer|min:1',
            'supplies.*.unit_cost' => 'nullable|numeric|min:0',
            'supplies.*.note' => 'nullable|string|max:500',
        ]);

        DB::transaction(function() use ($validated) {
            foreach ($validated['supplies'] as $supply) {
                $product = Product::findOrFail($supply['product_id']);

                // Capturer stock AVANT modification pour audit trail
                $previous = $product->current_stock;
                $new = $previous + $supply['quantity'];

                // Créer mouvement de stock avec previous/new pour traçabilité
                StockMovement::create([
                    'product_id' => $product->id,
                    'user_id' => auth()->id(),
                    'type' => 'IN',
                    'quantity' => $supply['quantity'],
                    'previous_stock' => $previous,
                    'new_stock' => $new,
                    'reason' => 'Approvisionnement',
                    'notes' => $supply['note'] ?? null,
                    'unit_cost' => $supply['unit_cost'] ?? $product->purchase_price,
                ]);

                // Mettre à jour stock produit
                $product->update(['current_stock' => $new]);

                // Mettre à jour prix d'achat (purchase_price) si fourni
                if (isset($supply['unit_cost']) && $supply['unit_cost'] > 0) {
                    $product->update(['purchase_price' => $supply['unit_cost']]);
                }
            }
        });

        return redirect()
            ->route('gerant.supplies.index')
            ->with('success', 'Approvisionnement enregistré avec succès.');
    }

    /**
     * Détails d'un approvisionnement
     */
    public function show(StockMovement $supply)
    {
        $supply->load(['product', 'user']);

        return view('gerant.supplies.show', compact('supply'));
    }
}
