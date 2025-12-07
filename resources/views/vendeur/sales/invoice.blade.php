@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-4">Facture {{ $sale->invoice_number }}</h1>

<div class="bg-white p-6 rounded shadow mb-6">
    <div class="flex justify-between mb-4">
        <div>
            <p><strong>Date :</strong> {{ $sale->sold_at }}</p>
            <p><strong>Vendeur :</strong> {{ $sale->seller->name }}</p>
        </div>
        <div>
            <p><strong>Client :</strong> {{ $sale->client_name ?? 'N/A' }}</p>
            <p><strong>Téléphone :</strong> {{ $sale->client_phone ?? 'N/A' }}</p>
        </div>
    </div>

    <table class="w-full mb-4">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 text-left">Produit</th>
                <th class="p-2 text-right">Qté</th>
                <th class="p-2 text-right">Prix unitaire</th>
                <th class="p-2 text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sale->items as $item)
                <tr class="border-t">
                    <td class="p-2">{{ $item->product->name }}</td>
                    <td class="p-2 text-right">{{ $item->quantity }}</td>
                    <td class="p-2 text-right">{{ number_format($item->unit_price, 2) }}</td>
                    <td class="p-2 text-right">{{ number_format($item->total_price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="flex justify-end">
        <div class="text-right">
            <p><strong>Total :</strong> {{ number_format($sale->total_amount, 2) }}</p>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('vendeur.sales.invoice.pdf', $sale) }}"
           class="px-4 py-2 bg-smartblack text-white rounded">
            Télécharger PDF
        </a>
    </div>
</div>

@endsection
