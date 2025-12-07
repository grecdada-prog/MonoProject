@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-6">Mes ventes</h1>

<a href="{{ route('vendeur.sales.create') }}"
   class="px-4 py-2 bg-smartblack text-white rounded hover:bg-gray-900">
    Nouvelle vente
</a>

@if (session('success'))
    <div class="bg-green-100 text-green-700 px-4 py-2 rounded mt-4">
        {{ session('success') }}
    </div>
@endif

<table class="w-full mt-6 bg-white rounded shadow">
    <thead class="bg-gray-100">
        <tr>
            <th class="p-2 text-left">Facture</th>
            <th class="p-2 text-left">Date</th>
            <th class="p-2 text-left">Montant</th>
            <th class="p-2 text-left">Articles</th>
            <th class="p-2 text-left">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($sales as $sale)
            <tr class="border-t">
                <td class="p-2">{{ $sale->invoice_number }}</td>
                <td class="p-2">{{ $sale->sold_at }}</td>
                <td class="p-2">{{ number_format($sale->total_amount, 2) }}</td>
                <td class="p-2">{{ $sale->total_items }}</td>
                <td class="p-2 flex gap-2">
                    <a href="{{ route('vendeur.sales.invoice', $sale) }}" class="text-blue-600 text-sm hover:underline">
                        Voir
                    </a>
                    <a href="{{ route('vendeur.sales.invoice.pdf', $sale) }}" class="text-smartred text-sm hover:underline">
                        PDF
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection
