@extends('layouts.app')

@section('title', 'Modifier Produit')
@section('page-title', 'Modifier Produit')

@section('content')
<div class="max-w-4xl mx-auto">

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-red-600 rounded-lg flex items-center justify-center text-white font-bold text-2xl">
                {{ strtoupper(substr($product->name, 0, 2)) }}
            </div>
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Modifier Produit</h2>
                <p class="text-gray-600 mt-1">{{ $product->name }}</p>
            </div>
        </div>

        <a href="{{ route('gerant.products.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Retour
        </a>
    </div>

    {{-- FORM CARD --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-8">
            <form method="POST" action="{{ route('gerant.products.update', $product) }}" id="updateProductForm">
                @csrf

                {{-- PRODUCT INFO SECTION --}}
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        Informations du produit
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- NAME --}}
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nom du produit <span class="text-red-600">*</span>
                            </label>
                            <input type="text"
                                   id="name"
                                   name="name"
                                   value="{{ old('name', $product->name) }}"
                                   required
                                   maxlength="255"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition @error('name') border-red-500 @enderror"
                                   placeholder="Ex: iPhone 15 Pro Max">
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- SKU --}}
                        <div>
                            <label for="sku" class="block text-sm font-semibold text-gray-700 mb-2">
                                Code SKU <span class="text-red-600">*</span>
                            </label>
                            <input type="text"
                                   id="sku"
                                   name="sku"
                                   value="{{ old('sku', $product->sku) }}"
                                   required
                                   maxlength="255"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition @error('sku') border-red-500 @enderror"
                                   placeholder="Ex: IPH15PM-BLK-256">
                            @error('sku')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Code unique d'identification du produit</p>
                        </div>

                        {{-- BARCODE --}}
                        <div>
                            <label for="barcode" class="block text-sm font-semibold text-gray-700 mb-2">
                                Code-barres
                            </label>
                            <input type="text"
                                   id="barcode"
                                   name="barcode"
                                   value="{{ old('barcode', $product->barcode) }}"
                                   maxlength="255"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition @error('barcode') border-red-500 @enderror"
                                   placeholder="Ex: 194253107415">
                            @error('barcode')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Optionnel</p>
                        </div>

                        {{-- DESCRIPTION --}}
                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                                Description
                            </label>
                            <textarea id="description"
                                      name="description"
                                      rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition @error('description') border-red-500 @enderror"
                                      placeholder="Description détaillée du produit...">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- DIVIDER --}}
                <div class="border-t border-gray-200 my-8"></div>

                {{-- PRICING SECTION --}}
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Tarification
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- COST PRICE --}}
                        <div>
                            <label for="cost_price" class="block text-sm font-semibold text-gray-700 mb-2">
                                Prix de revient (coût) <span class="text-red-600">*</span>
                            </label>
                            <div class="relative">
                                <input type="number"
                                       id="cost_price"
                                       name="cost_price"
                                       value="{{ old('cost_price', $product->cost_price) }}"
                                       required
                                       step="0.01"
                                       min="0"
                                       class="w-full px-4 py-3 pr-16 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition @error('cost_price') border-red-500 @enderror"
                                       placeholder="0.00">
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 text-sm">FCFA</span>
                            </div>
                            @error('cost_price')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Prix d'achat du produit</p>
                        </div>

                        {{-- UNIT PRICE --}}
                        <div>
                            <label for="unit_price" class="block text-sm font-semibold text-gray-700 mb-2">
                                Prix de vente <span class="text-red-600">*</span>
                            </label>
                            <div class="relative">
                                <input type="number"
                                       id="unit_price"
                                       name="unit_price"
                                       value="{{ old('unit_price', $product->unit_price) }}"
                                       required
                                       step="0.01"
                                       min="0"
                                       class="w-full px-4 py-3 pr-16 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition @error('unit_price') border-red-500 @enderror"
                                       placeholder="0.00">
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 text-sm">FCFA</span>
                            </div>
                            @error('unit_price')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Prix de vente au client</p>
                        </div>
                    </div>
                </div>

                {{-- DIVIDER --}}
                <div class="border-t border-gray-200 my-8"></div>

                {{-- STOCK SECTION --}}
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        Gestion du stock
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- CURRENT STOCK (READONLY) --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Stock actuel
                            </label>
                            <div class="w-full px-4 py-3 bg-gray-100 border border-gray-300 rounded-lg text-gray-700 font-semibold">
                                {{ $product->current_stock }} unités
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Utilisez les ajustements de stock pour modifier</p>
                        </div>

                        {{-- ALERT THRESHOLD --}}
                        <div>
                            <label for="stock_alert_threshold" class="block text-sm font-semibold text-gray-700 mb-2">
                                Seuil d'alerte <span class="text-red-600">*</span>
                            </label>
                            <input type="number"
                                   id="stock_alert_threshold"
                                   name="stock_alert_threshold"
                                   value="{{ old('stock_alert_threshold', $product->stock_alert_threshold) }}"
                                   required
                                   min="0"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition @error('stock_alert_threshold') border-red-500 @enderror"
                                   placeholder="10">
                            @error('stock_alert_threshold')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Alerte quand le stock descend en dessous</p>
                        </div>
                    </div>
                </div>

                {{-- DIVIDER --}}
                <div class="border-t border-gray-200 my-8"></div>

                {{-- STATUS SECTION --}}
                <div class="mb-8">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox"
                               name="is_active"
                               value="1"
                               {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                               class="w-5 h-5 text-red-600 border-gray-300 rounded focus:ring-red-500">
                        <div>
                            <span class="text-sm font-semibold text-gray-900">Produit actif</span>
                            <p class="text-xs text-gray-500">Décochez pour désactiver ce produit (non visible pour les vendeurs)</p>
                        </div>
                    </label>
                </div>

                {{-- METADATA --}}
                <div class="mb-8 p-4 bg-gray-50 border border-gray-200 rounded-lg">
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-600 font-medium mb-1">Créé le</p>
                            <p class="text-gray-900">{{ $product->created_at->format('d/m/Y à H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 font-medium mb-1">Dernière modification</p>
                            <p class="text-gray-900">{{ $product->updated_at->format('d/m/Y à H:i') }}</p>
                        </div>
                    </div>
                </div>

                {{-- ACTIONS --}}
                <div class="flex items-center justify-end gap-4">
                    <a href="{{ route('gerant.products.index') }}"
                       class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                        Annuler
                    </a>
                    <button type="button"
                            onclick="confirmAction(
                                'Modifier le produit',
                                'Êtes-vous sûr de vouloir enregistrer ces modifications pour {{ $product->name }} ?',
                                () => document.getElementById('updateProductForm').submit(),
                                { confirmText: 'Modifier', confirmClass: 'bg-red-600 hover:bg-red-700' }
                            )"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition shadow-lg hover:shadow-xl font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
