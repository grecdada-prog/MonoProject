@extends('layouts.app')

@section('title', 'Dashboard Vendeur')
@section('page-title', 'Dashboard Vendeur')

@section('content')
<div class="max-w-7xl mx-auto">

    {{-- HEADER --}}
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Bienvenue, {{ auth()->user()->name }}</h2>
        <p class="text-gray-600 mt-1">Voici un aperçu de vos ventes</p>
    </div>

    {{-- TODAY STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        {{-- VENTES DU JOUR --}}
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Ventes aujourd'hui</p>
                    <p class="text-4xl font-bold text-blue-600">{{ $totalSalesToday }}</p>
                    <p class="text-xs text-gray-500 mt-2">Transactions du jour</p>
                </div>
                <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- CA DU JOUR --}}
        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl shadow-sm p-6 text-white hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm mb-1">CA aujourd'hui</p>
                    <p class="text-4xl font-bold">{{ number_format($revenueToday, 0, ',', ' ') }}</p>
                    <p class="text-xs text-red-100 mt-2">FCFA</p>
                </div>
                <div class="w-16 h-16 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- TICKET MOYEN --}}
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-sm p-6 text-white hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm mb-1">Panier moyen</p>
                    <p class="text-4xl font-bold">{{ number_format($avgTicket, 0, ',', ' ') }}</p>
                    <p class="text-xs text-green-100 mt-2">FCFA / vente</p>
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
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        {{-- CREATE SALE --}}
        <a href="{{ route('vendeur.sales.create') }}"
           class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md hover:border-red-200 transition group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center group-hover:bg-red-600 transition">
                    <svg class="w-6 h-6 text-red-600 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Nouvelle Vente</h3>
                    <p class="text-sm text-gray-500">Créer une transaction</p>
                </div>
            </div>
        </a>

        {{-- VIEW SALES --}}
        <a href="{{ route('vendeur.sales.index') }}"
           class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md hover:border-red-200 transition group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-600 transition">
                    <svg class="w-6 h-6 text-blue-600 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Mes Ventes</h3>
                    <p class="text-sm text-gray-500">Historique complet</p>
                </div>
            </div>
        </a>

        {{-- LAST INVOICE --}}
        <a href="{{ route('vendeur.dashboard.lastpdf') }}"
           class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md hover:border-red-200 transition group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center group-hover:bg-gray-600 transition">
                    <svg class="w-6 h-6 text-gray-600 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Dernière Facture</h3>
                    <p class="text-sm text-gray-500">Télécharger PDF</p>
                </div>
            </div>
        </a>
    </div>

    {{-- SALES CHART --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 mb-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Évolution des ventes</h3>
                <p class="text-sm text-gray-600">Chiffre d'affaires des 7 derniers jours</p>
            </div>
            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
        </div>
        <div class="relative" style="height: 300px;">
            <canvas id="chartSales7days"></canvas>
        </div>
    </div>

    {{-- OVERALL STATS --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Performance globale</h3>
                <p class="text-sm text-gray-600">Statistiques depuis le début</p>
            </div>
            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                </svg>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- TOTAL SALES --}}
            <div class="p-4 bg-gray-50 rounded-lg">
                <h4 class="font-semibold text-gray-900 mb-4">Ventes totales</h4>
                <div class="space-y-3">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Nombre de transactions</span>
                        <span class="font-semibold text-gray-900 text-lg">{{ $totalSales }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Chiffre d'affaires total</span>
                        <span class="font-semibold text-red-600 text-lg">{{ number_format($totalRevenue, 0, ',', ' ') }} FCFA</span>
                    </div>
                </div>
            </div>

            {{-- TODAY SUMMARY --}}
            <div class="p-4 bg-gray-50 rounded-lg">
                <h4 class="font-semibold text-gray-900 mb-4">Résumé du jour</h4>
                <div class="space-y-3">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Ventes</span>
                        <span class="font-semibold text-blue-600 text-lg">{{ $totalSalesToday }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">CA du jour</span>
                        <span class="font-semibold text-red-600 text-lg">{{ number_format($revenueToday, 0, ',', ' ') }} FCFA</span>
                    </div>
                    <div class="flex items-center justify-between text-sm border-t border-gray-200 pt-3">
                        <span class="text-gray-600">Panier moyen</span>
                        <span class="font-semibold text-green-600 text-lg">{{ number_format($avgTicket, 0, ',', ' ') }} FCFA</span>
                    </div>
                </div>
            </div>
        </div>

        @if($totalSalesToday > 0)
            <div class="mt-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex gap-3">
                    <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="text-sm text-green-800">
                        <p class="font-semibold">Excellent travail !</p>
                        <p>Vous avez réalisé {{ $totalSalesToday }} vente(s) aujourd'hui pour un total de {{ number_format($revenueToday, 0, ',', ' ') }} FCFA.</p>
                    </div>
                </div>
            </div>
        @else
            <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex gap-3">
                    <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="text-sm text-blue-800">
                        <p class="font-semibold">Prêt à commencer ?</p>
                        <p>Aucune vente enregistrée aujourd'hui. Cliquez sur "Nouvelle Vente" pour commencer.</p>
                    </div>
                </div>
            </div>
        @endif
    </div>

</div>

<script>
// Fetch sales data and render chart
fetch('/stats/sales-7days')
    .then(r => r.json())
    .then(data => {
        const ctx = document.getElementById('chartSales7days').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.map(d => d.d),
                datasets: [{
                    label: 'Chiffre d\'affaires (FCFA)',
                    data: data.map(d => d.total),
                    borderColor: '#DC2626',
                    backgroundColor: 'rgba(220, 38, 38, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#DC2626',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            font: {
                                size: 12,
                                family: 'system-ui'
                            },
                            padding: 20
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleFont: {
                            size: 14
                        },
                        bodyFont: {
                            size: 13
                        },
                        callbacks: {
                            label: function(context) {
                                return 'CA: ' + context.parsed.y.toLocaleString('fr-FR') + ' FCFA';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString('fr-FR') + ' F';
                            },
                            font: {
                                size: 11
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 11
                            }
                        }
                    }
                }
            }
        });
    })
    .catch(err => console.error('Erreur chargement graphique:', err));
</script>

@endsection
