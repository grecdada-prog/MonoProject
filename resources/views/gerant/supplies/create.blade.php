@extends('layouts.app')

@section('title', 'Nouvel Approvisionnement')
@section('page-title', 'Enregistrer un Approvisionnement')

@section('content')
<div class="max-w-7xl mx-auto">

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Nouvel Approvisionnement</h2>
            <p class="text-gray-600 mt-1">Enregistrez une entrée de stock pour un ou plusieurs produits</p>
        </div>

        <a href="{{ route('gerant.supplies.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Retour
        </a>
    </div>

    {{-- FORM --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        <form method="POST" action="{{ route('gerant.supplies.store') }}" x-data="supplyForm()">
            @csrf

            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    Produits à Approvisionner
                </h3>

                {{-- Supply Items --}}
                <div class="space-y-4">
                    <template x-for="(item, index) in items" :key="index">
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            {{-- Product Selection --}}
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Produit <span class="text-red-600">*</span>
                                </label>
                                <select x-model="items[index].product_id"
                                        :name="`supplies[${index}][product_id]`"
                                        @change="updateProductInfo(index)"
                                        required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                    <option value="">Sélectionnez un produit...</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}"
                                                data-code="{{ $product->sku }}"
                                                data-stock="{{ $product->current_stock }}"
                                                data-cost="{{ $product->purchase_price }}">
                                            {{ $product->name }} (Stock: {{ $product->current_stock }})
                                        </option>
                                    @endforeach
                                </select>
                                <p class="mt-1 text-xs text-gray-500">
                                    SKU: <span x-text="items[index].product_code || '-'"></span>
                                    | Stock actuel: <span x-text="items[index].current_stock || '0'"></span>
                                </p>
                            </div>

                            {{-- Quantity --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Quantité <span class="text-red-600">*</span>
                                </label>
                                <input type="number"
                                       x-model.number="items[index].quantity"
                                       :name="`supplies[${index}][quantity]`"
                                       @input="calculateTotal(index)"
                                       min="1"
                                       required
                                       placeholder="Ex: 100"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                            </div>

                            {{-- Unit Cost --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Prix Unitaire (F)
                                </label>
                                <input type="number"
                                       x-model.number="items[index].unit_cost"
                                       :name="`supplies[${index}][unit_cost]`"
                                       @input="calculateTotal(index)"
                                       min="0"
                                       step="1"
                                       placeholder="Optionnel"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                <p class="mt-1 text-xs text-gray-500">
                                    Actuel: <span x-text="items[index].current_cost || '0'"></span> F
                                </p>
                            </div>

                            {{-- Total & Actions --}}
                            <div class="flex items-end gap-2">
                                <div class="flex-1">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Total</label>
                                    <div class="px-4 py-2 bg-green-100 border border-green-300 rounded-lg text-center">
                                        <span class="font-bold text-green-800" x-text="formatCurrency(items[index].total || 0)"></span>
                                    </div>
                                </div>
                                <button type="button"
                                        @click="removeItem(index)"
                                        x-show="items.length > 1"
                                        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition"
                                        title="Supprimer">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </template>

                    {{-- Add Item Button --}}
                    <button type="button"
                            @click="addItem()"
                            class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg text-gray-600 hover:border-red-500 hover:text-red-600 transition font-medium">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Ajouter un Produit
                    </button>
                </div>
            </div>

            {{-- Reason --}}
            <div class="mb-6">
                <label for="reason" class="block text-sm font-semibold text-gray-700 mb-2">
                    Raison / Note
                </label>
                <textarea id="reason"
                          name="reason"
                          rows="2"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                          placeholder="Ex: Approvisionnement hebdomadaire, Commande urgente...">{{ old('reason') }}</textarea>
            </div>

            {{-- Summary --}}
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
                <h4 class="font-bold text-gray-900 mb-3">Récapitulatif</h4>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Nombre de produits</p>
                        <p class="text-2xl font-bold text-gray-900" x-text="items.length"></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Montant total estimé</p>
                        <p class="text-2xl font-bold text-green-600" x-text="formatCurrency(grandTotal())"></p>
                    </div>
                </div>
            </div>

            {{-- ACTIONS --}}
            <div class="flex items-center gap-4 pt-6 border-t border-gray-200">
                <button type="submit"
                        class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition shadow-lg hover:shadow-xl font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                    </svg>
                    Enregistrer l'Approvisionnement
                </button>

                <a href="{{ route('gerant.supplies.index') }}"
                   class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium">
                    Annuler
                </a>
            </div>
        </form>
    </div>

</div>

<script>
function supplyForm() {
    return {
        items: [{
            product_id: '',
            product_code: '',
            current_stock: 0,
            current_cost: 0,
            quantity: '',
            unit_cost: '',
            total: 0
        }],

        addItem() {
            this.items.push({
                product_id: '',
                product_code: '',
                current_stock: 0,
                current_cost: 0,
                quantity: '',
                unit_cost: '',
                total: 0
            });
        },

        removeItem(index) {
            if (this.items.length > 1) {
                this.items.splice(index, 1);
            }
        },

        updateProductInfo(index) {
            const select = event.target;
            const option = select.options[select.selectedIndex];

            this.items[index].product_code = option.dataset.code || '';
            this.items[index].current_stock = option.dataset.stock || 0;
            this.items[index].current_cost = option.dataset.cost || 0;

            // Set default unit cost to current cost if not set
            if (!this.items[index].unit_cost) {
                this.items[index].unit_cost = parseFloat(option.dataset.cost) || 0;
            }

            this.calculateTotal(index);
        },

        calculateTotal(index) {
            const qty = parseFloat(this.items[index].quantity) || 0;
            const cost = parseFloat(this.items[index].unit_cost) || 0;
            this.items[index].total = qty * cost;
        },

        grandTotal() {
            return this.items.reduce((sum, item) => sum + (item.total || 0), 0);
        },

        formatCurrency(value) {
            return new Intl.NumberFormat('fr-FR').format(value) + ' F';
        }
    }
}
</script>
@endsection
