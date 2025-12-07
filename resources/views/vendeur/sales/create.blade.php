@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-6">Nouvelle vente</h1>

<form method="POST" action="{{ route('vendeur.sales.store') }}"
      class="bg-white p-6 rounded shadow w-full md:w-2/3">
    @csrf

    <div id="items-container" class="space-y-4 mb-6">
        <div class="item-row flex gap-4">
            <select name="items[0][product_id]" class="flex-1 border rounded px-2 py-1">
                <option value="">-- Produit --</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">
                        {{ $product->name }} (Stock: {{ $product->current_stock }})
                    </option>
                @endforeach
            </select>

            <input type="number" name="items[0][quantity]" value="1"
                   class="w-24 border rounded px-2 py-1" min="1">
        </div>
    </div>

    <button type="button" onclick="addItemRow()"
            class="mb-4 px-3 py-1 border border-smartblack text-smartblack rounded">
        + Ajouter ligne
    </button>

    <div class="mb-4">
        <label class="block mb-1 font-semibold">Nom client (optionnel)</label>
        <input type="text" name="client_name" class="w-full border rounded px-3 py-2">
    </div>

    <div class="mb-4">
        <label class="block mb-1 font-semibold">Téléphone client (optionnel)</label>
        <input type="text" name="client_phone" class="w-full border rounded px-3 py-2">
    </div>

    <button class="px-4 py-2 bg-smartblack text-white rounded">
        Enregistrer la vente
    </button>
</form>

<script>
    let itemIndex = 1;

    function addItemRow() {
        const container = document.getElementById('items-container');
        const row = document.createElement('div');
        row.className = 'item-row flex gap-4';

        row.innerHTML = `
            <select name="items[${itemIndex}][product_id]" class="flex-1 border rounded px-2 py-1">
                <option value="">-- Produit --</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">
                        {{ $product->name }} (Stock: {{ $product->current_stock }})
                    </option>
                @endforeach
            </select>

            <input type="number" name="items[${itemIndex}][quantity]" value="1"
                   class="w-24 border rounded px-2 py-1" min="1">
        `;

        container.appendChild(row);
        itemIndex++;
    }
</script>

@endsection
