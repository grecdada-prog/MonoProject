@extends('layouts.app')

@section('title', 'Produits & Stock')
@section('page-title', 'Produits & Stock')

@section('content')
<div class="max-w-7xl mx-auto">

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Gestion des Produits</h2>
            <p class="text-gray-600 mt-1">Gérez votre inventaire et vos stocks</p>
        </div>

        <a href="{{ route('gerant.products.create') }}"
           class="inline-flex items-center gap-2 px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition shadow-lg hover:shadow-xl font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Nouveau Produit
        </a>
    </div>

    {{-- STATS CARDS --}}
    @php
        $totalProducts = $products->count();
        $lowStockProducts = $products->filter(fn($p) => $p->current_stock <= $p->stock_alert_threshold)->count();
        $outOfStockProducts = $products->filter(fn($p) => $p->current_stock == 0)->count();
        $totalStockValue = $products->sum(fn($p) => $p->current_stock * $p->unit_price);
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        {{-- TOTAL PRODUCTS --}}
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Produits</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalProducts }}</p>
                </div>
                <div class="w-14 h-14 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- LOW STOCK --}}
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Stock Faible</p>
                    <p class="text-3xl font-bold text-orange-600">{{ $lowStockProducts }}</p>
                </div>
                <div class="w-14 h-14 bg-orange-100 rounded-lg flex items-center justify-center">
                    <svg class="w-7 h-7 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- OUT OF STOCK --}}
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Rupture</p>
                    <p class="text-3xl font-bold text-red-600">{{ $outOfStockProducts }}</p>
                </div>
                <div class="w-14 h-14 bg-red-100 rounded-lg flex items-center justify-center">
                    <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- STOCK VALUE --}}
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Valeur Stock</p>
                    <p class="text-2xl font-bold text-green-600">{{ number_format($totalStockValue, 0, ',', ' ') }}</p>
                    <p class="text-xs text-gray-500">FCFA</p>
                </div>
                <div class="w-14 h-14 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Produit</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Prix</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Stock</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($products as $product)
                        @php
                            $stockPercentage = $product->stock_alert_threshold > 0
                                ? ($product->current_stock / $product->stock_alert_threshold) * 100
                                : 100;

                            if ($product->current_stock == 0) {
                                $stockStatus = 'Rupture';
                                $stockColor = 'bg-red-100 text-red-800';
                                $stockDot = 'bg-red-600';
                            } elseif ($product->current_stock <= $product->stock_alert_threshold) {
                                $stockStatus = 'Stock faible';
                                $stockColor = 'bg-orange-100 text-orange-800';
                                $stockDot = 'bg-orange-600';
                            } else {
                                $stockStatus = 'En stock';
                                $stockColor = 'bg-green-100 text-green-800';
                                $stockDot = 'bg-green-600';
                            }
                        @endphp
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-red-600 rounded-lg flex items-center justify-center text-white font-bold">
                                        {{ strtoupper(substr($product->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-900">{{ $product->name }}</div>
                                        <div class="text-sm text-gray-500">SKU: {{ $product->sku }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm">
                                    <div class="font-semibold text-gray-900">{{ number_format($product->unit_price, 0, ',', ' ') }} FCFA</div>
                                    @if($product->cost_price)
                                        <div class="text-xs text-gray-500">Coût: {{ number_format($product->cost_price, 0, ',', ' ') }} FCFA</div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm">
                                    <div class="font-semibold text-gray-900">{{ $product->current_stock }} unités</div>
                                    <div class="text-xs text-gray-500">Seuil: {{ $product->stock_alert_threshold }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 {{ $stockColor }} text-xs font-semibold rounded-full">
                                    <span class="w-1.5 h-1.5 {{ $stockDot }} rounded-full"></span>
                                    {{ $stockStatus }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    {{-- QUICK ADD STOCK --}}
                                    <form method="POST" action="{{ route('gerant.products.adjustStock', $product) }}" class="inline">
                                        @csrf
                                        <input type="hidden" name="type" value="IN">
                                        <input type="hidden" name="quantity" value="10">
                                        <input type="hidden" name="reason" value="Réapprovisionnement rapide">
                                        <button type="submit"
                                                class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition"
                                                title="Ajouter 10 unités">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                        </button>
                                    </form>

                                    {{-- EDIT --}}
                                    <a href="{{ route('gerant.products.edit', $product) }}"
                                       class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition"
                                       title="Modifier">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>

                                    {{-- DELETE --}}
                                    <form method="POST" action="{{ route('gerant.products.delete', $product) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                                onclick="confirmAction(
                                                    'Supprimer le produit',
                                                    'Êtes-vous sûr de vouloir supprimer {{ $product->name }} ? Cette action est irréversible.',
                                                    () => this.closest('form').submit(),
                                                    { confirmText: 'Supprimer', confirmClass: 'bg-red-600 hover:bg-red-700' }
                                                )"
                                                class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition"
                                                title="Supprimer">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-gray-900 font-semibold mb-1">Aucun produit</p>
                                        <p class="text-gray-500 text-sm mb-4">Commencez par créer votre premier produit</p>
                                        <a href="{{ route('gerant.products.create') }}"
                                           class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-medium">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                            Créer un produit
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if($products->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $products->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
