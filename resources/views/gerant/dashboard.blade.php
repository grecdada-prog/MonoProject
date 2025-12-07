@extends('layouts.app')

@section('title', 'Dashboard Gérant')
@section('page-title', 'Dashboard Gérant')

@section('content')
<div class="max-w-7xl mx-auto">

    {{-- HEADER --}}
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Tableau de bord Gérant</h2>
        <p class="text-gray-600 mt-1">Pilotez votre activité commerciale</p>
    </div>

    {{-- PRIMARY STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        {{-- VENDEURS --}}
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Mes Vendeurs</p>
                    <p class="text-4xl font-bold text-gray-900">{{ $totalVendeurs }}</p>
                    <p class="text-xs text-gray-500 mt-2">
                        <span class="text-green-600 font-semibold">{{ $activeVendeurs }}</span> en activité
                    </p>
                </div>
                <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- VENTES DU JOUR --}}
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Ventes du jour</p>
                    <p class="text-4xl font-bold text-blue-600">{{ $totalSalesToday }}</p>
                    <p class="text-xs text-gray-500 mt-2">Transactions aujourd'hui</p>
                </div>
                <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- PRODUITS EN RUPTURE --}}
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Produits en rupture</p>
                    <p class="text-4xl font-bold {{ $lowStockCount > 0 ? 'text-orange-600' : 'text-gray-900' }}">{{ $lowStockCount }}</p>
                    <p class="text-xs text-gray-500 mt-2">Nécessite réapprovisionnement</p>
                </div>
                <div class="w-16 h-16 {{ $lowStockCount > 0 ? 'bg-orange-100' : 'bg-gray-100' }} rounded-lg flex items-center justify-center">
                    <svg class="w-8 h-8 {{ $lowStockCount > 0 ? 'text-orange-600' : 'text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- FINANCIAL STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        {{-- REVENUE --}}
        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl shadow-sm p-6 text-white hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm mb-1">Chiffre d'affaires du jour</p>
                    <p class="text-4xl font-bold">{{ number_format($revenueToday, 0, ',', ' ') }} FCFA</p>
                    <p class="text-xs text-red-100 mt-2">Revenus d'aujourd'hui</p>
                </div>
                <div class="w-16 h-16 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- PROFIT --}}
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-sm p-6 text-white hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm mb-1">Bénéfice du jour</p>
                    <p class="text-4xl font-bold">{{ number_format($profitToday, 0, ',', ' ') }} FCFA</p>
                    <p class="text-xs text-green-100 mt-2">Profit net aujourd'hui</p>
                </div>
                <div class="w-16 h-16 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- QUICK ACTIONS --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        {{-- MANAGE VENDEURS --}}
        <a href="{{ route('gerant.vendeurs.index') }}"
           class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md hover:border-red-200 transition group">
            <div class="flex flex-col items-center text-center gap-3">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-600 transition">
                    <svg class="w-6 h-6 text-blue-600 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Mes Vendeurs</h3>
                    <p class="text-xs text-gray-500 mt-1">Gérer l'équipe</p>
                </div>
            </div>
        </a>

        {{-- MANAGE PRODUCTS --}}
        <a href="{{ route('gerant.products.index') }}"
           class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md hover:border-red-200 transition group">
            <div class="flex flex-col items-center text-center gap-3">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-600 transition">
                    <svg class="w-6 h-6 text-purple-600 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Produits</h3>
                    <p class="text-xs text-gray-500 mt-1">Gérer le stock</p>
                </div>
            </div>
        </a>

        {{-- CREATE VENDEUR --}}
        <a href="{{ route('gerant.vendeurs.create') }}"
           class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md hover:border-red-200 transition group">
            <div class="flex flex-col items-center text-center gap-3">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-600 transition">
                    <svg class="w-6 h-6 text-green-600 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Nouveau Vendeur</h3>
                    <p class="text-xs text-gray-500 mt-1">Ajouter à l'équipe</p>
                </div>
            </div>
        </a>

        {{-- CREATE PRODUCT --}}
        <a href="{{ route('gerant.products.create') }}"
           class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md hover:border-red-200 transition group">
            <div class="flex flex-col items-center text-center gap-3">
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center group-hover:bg-red-600 transition">
                    <svg class="w-6 h-6 text-red-600 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Nouveau Produit</h3>
                    <p class="text-xs text-gray-500 mt-1">Ajouter au stock</p>
                </div>
            </div>
        </a>
    </div>

    {{-- BUSINESS OVERVIEW --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Aperçu de l'activité</h3>
                <p class="text-sm text-gray-600">Résumé de la journée</p>
            </div>
            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- TEAM INFO --}}
            <div class="p-4 bg-gray-50 rounded-lg">
                <h4 class="font-semibold text-gray-900 mb-4">Équipe</h4>
                <div class="space-y-3">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Total vendeurs</span>
                        <span class="font-semibold text-gray-900">{{ $totalVendeurs }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Vendeurs actifs</span>
                        <span class="font-semibold text-green-600">{{ $activeVendeurs }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Taux d'activité</span>
                        <span class="font-semibold text-blue-600">
                            {{ $totalVendeurs > 0 ? round(($activeVendeurs / $totalVendeurs) * 100) : 0 }}%
                        </span>
                    </div>
                </div>
            </div>

            {{-- SALES INFO --}}
            <div class="p-4 bg-gray-50 rounded-lg">
                <h4 class="font-semibold text-gray-900 mb-4">Ventes & Stock</h4>
                <div class="space-y-3">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Ventes du jour</span>
                        <span class="font-semibold text-blue-600">{{ $totalSalesToday }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">CA du jour</span>
                        <span class="font-semibold text-red-600">{{ number_format($revenueToday, 0, ',', ' ') }} FCFA</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Bénéfice du jour</span>
                        <span class="font-semibold text-green-600">{{ number_format($profitToday, 0, ',', ' ') }} FCFA</span>
                    </div>
                    <div class="flex items-center justify-between text-sm border-t border-gray-200 pt-3">
                        <span class="text-gray-600">Produits en rupture</span>
                        <span class="font-semibold {{ $lowStockCount > 0 ? 'text-orange-600' : 'text-gray-900' }}">{{ $lowStockCount }}</span>
                    </div>
                </div>

                @if($lowStockCount > 0)
                    <div class="mt-4 p-3 bg-orange-50 border border-orange-200 rounded-lg">
                        <div class="flex gap-2">
                            <svg class="w-5 h-5 text-orange-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <div>
                                <p class="text-xs font-semibold text-orange-800">Attention requise</p>
                                <p class="text-xs text-orange-700">{{ $lowStockCount }} produit(s) nécessitent un réapprovisionnement</p>
                                <a href="{{ route('gerant.products.index') }}" class="text-xs text-orange-800 font-semibold hover:underline mt-1 inline-block">
                                    Voir les produits →
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

</div>
@endsection
