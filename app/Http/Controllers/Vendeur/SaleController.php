<?php

namespace App\Http\Controllers\Vendeur;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Store;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\InvoiceNumberService;

class SaleController extends Controller
{
    public function index()
    {
        return view('vendeur.sales.index', [
            'sales' => Sale::where('seller_id', Auth::id())
                ->orderByDesc('sold_at')
                ->limit(50)
                ->get(),
        ]);
    }

    public function create()
    {
        $user = auth()->user();

        // Filtrer produits par store_id si le vendeur a un magasin assigné
        $products = Product::where('is_active', true)
            ->when($user->store_id, function($q) use ($user) {
                $q->where('store_id', $user->store_id);
            })
            ->orderBy('name')
            ->get();

        return view('vendeur.sales.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity'   => 'required|integer|min:1',
            'client_name'        => 'nullable|string|max:255',
            'client_phone'       => 'nullable|string|max:255',
        ]);

        $seller = Auth::user();
        $managerId = $seller->manager_id;

        $invoiceService = new InvoiceNumberService();

        DB::transaction(function () use ($request, $seller, $managerId, $invoiceService) {

            $totalAmount = 0;
            $totalCost   = 0;
            $totalItems  = 0;

            // Génération du n° de facture sécurisé
            $invoiceNumber = $invoiceService->generate();

            // Création de la vente
            $sale = Sale::create([
                'seller_id'       => $seller->id,
                'manager_id'      => $managerId,
                'total_items'     => 0,
                'total_amount'    => 0,
                'total_cost'      => 0,
                'profit'          => 0,
                'status'          => 'COMPLETED',
                'payment_method'  => 'CASH',
                'sold_at'         => now(),
                'client_name'     => $request->client_name,
                'client_phone'    => $request->client_phone,
                'invoice_number'  => $invoiceNumber,
                'created_ip'      => $request->ip(),
                'created_user_agent' => $request->userAgent(),
            ]);

            // Process des items
            foreach ($request->items as $row) {
                // Vérifier que le produit appartient au magasin du vendeur (si store_id défini)
                // CRITICAL: lockForUpdate() prevents race condition on concurrent sales
                $product = Product::query()
                    ->where('id', $row['product_id'])
                    ->when($seller->store_id, function($q) use ($seller) {
                        $q->where('store_id', $seller->store_id);
                    })
                    ->lockForUpdate() // Pessimistic lock to prevent overselling
                    ->firstOrFail(); // Échoue si produit n'existe pas ou n'appartient pas au magasin

                $qty     = (int) $row['quantity'];

                $unitPrice = $product->sale_price;
                $unitCost  = $product->purchase_price;

                $lineTotal = $unitPrice * $qty;
                $lineCost  = $unitCost * $qty;

                $totalAmount += $lineTotal;
                $totalCost   += $lineCost;
                $totalItems  += $qty;

                // Ligne de vente
                SaleItem::create([
                    'sale_id'     => $sale->id,
                    'product_id'  => $product->id,
                    'quantity'    => $qty,
                    'unit_price'  => $unitPrice,
                    'total_price' => $lineTotal,
                    'unit_cost'   => $unitCost,
                    'total_cost'  => $lineCost,
                ]);

                // Stock - Validation insuffisance
                $previous = $product->current_stock;

                if ($previous < $qty) {
                    throw new \Exception("Stock insuffisant pour le produit '{$product->name}'. Disponible: {$previous}, Demandé: {$qty}");
                }

                $new = $previous - $qty;
                $product->update(['current_stock' => $new]);

                // Mouvement de stock
                StockMovement::create([
                    'product_id'    => $product->id,
                    'user_id'       => $seller->id,
                    'sale_id'       => $sale->id,
                    'type'          => 'OUT',
                    'quantity'      => $qty,
                    'previous_stock'=> $previous,
                    'new_stock'     => $new,
                    'reason'        => 'Vente',
                ]);
            }

            // Calcul du bénéfice
            $profit = $totalAmount - $totalCost;

            // Mise à jour finale
            $sale->update([
                'total_items'  => $totalItems,
                'total_amount' => $totalAmount,
                'total_cost'   => $totalCost,
                'profit'       => $profit,
            ]);
            event(new \App\Events\SaleCreatedEvent($sale));

            // Invalider cache Store stats si vendeur a un magasin
            if ($seller->store_id) {
                $store = Store::find($seller->store_id);
                if ($store) {
                    $store->clearStatsCache();
                }
            }

        });

        return redirect()->route('vendeur.sales.index')
            ->with('success', 'Vente enregistrée avec succès.');
    }

    public function invoice(Sale $sale)
    {
        $this->authorize('downloadInvoice', $sale);

        $sale->load('items.product', 'seller');

        return view('vendeur.sales.invoice', compact('sale'));
    }

    public function invoicePdf(Sale $sale)
    {
        $this->authorize('downloadInvoice', $sale);

        $sale->load('items.product', 'seller');

        $pdf = Pdf::loadView('vendeur.sales.invoice-pdf', compact('sale'));

        return $pdf->download($sale->invoice_number . '.pdf');
    }
}
