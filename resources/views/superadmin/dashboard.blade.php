@extends('layouts.app')

@section('title', 'Dashboard Super Admin')
@section('page-title', 'Dashboard Super Admin')

@section('content')
<div class="max-w-7xl mx-auto">

    {{-- HEADER --}}
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Vue d'ensemble du système</h2>
        <p class="text-gray-600 mt-1">Supervision complète de la plateforme SmartStock</p>
    </div>

    {{-- PRIMARY STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        {{-- TOTAL USERS --}}
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Utilisateurs</p>
                    <p class="text-4xl font-bold text-gray-900">{{ $totalUsers }}</p>
                    <p class="text-xs text-gray-500 mt-2">
                        <span class="text-green-600 font-semibold">{{ $activeUsers }}</span> actifs
                    </p>
                </div>
                <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- TOTAL GERANTS --}}
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Gérants</p>
                    <p class="text-4xl font-bold text-orange-600">{{ $totalGerants }}</p>
                    <p class="text-xs text-gray-500 mt-2">Gestionnaires de boutique</p>
                </div>
                <div class="w-16 h-16 bg-orange-100 rounded-lg flex items-center justify-center">
                    <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- TOTAL VENDEURS --}}
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Vendeurs</p>
                    <p class="text-4xl font-bold text-blue-600">{{ $totalVendeurs }}</p>
                    <p class="text-xs text-gray-500 mt-2">Personnel de vente</p>
                </div>
                <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- SECONDARY STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        {{-- VENTES DU JOUR --}}
        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl shadow-sm p-6 text-white hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm mb-1">Ventes du jour</p>
                    <p class="text-4xl font-bold">{{ $todaySales }}</p>
                    <p class="text-xs text-red-100 mt-2">Transactions aujourd'hui</p>
                </div>
                <div class="w-16 h-16 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- PRODUITS EN RUPTURE --}}
        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-sm p-6 text-white hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm mb-1">Produits en rupture</p>
                    <p class="text-4xl font-bold">{{ $lowStock }}</p>
                    <p class="text-xs text-orange-100 mt-2">Nécessite réapprovisionnement</p>
                </div>
                <div class="w-16 h-16 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- UTILISATEURS ACTIFS --}}
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-sm p-6 text-white hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm mb-1">Utilisateurs actifs</p>
                    <p class="text-4xl font-bold">{{ $activeUsers }}</p>
                    <p class="text-xs text-green-100 mt-2">Comptes activés</p>
                </div>
                <div class="w-16 h-16 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- QUICK ACTIONS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        {{-- USERS MANAGEMENT --}}
        <a href="{{ route('superadmin.users.index') }}"
           class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md hover:border-red-200 transition group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center group-hover:bg-red-600 transition">
                    <svg class="w-6 h-6 text-red-600 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Gérer les utilisateurs</h3>
                    <p class="text-sm text-gray-500">Ajouter, modifier ou supprimer</p>
                </div>
            </div>
        </a>

        {{-- ACTIVITY LOG --}}
        <a href="{{ route('superadmin.activity.index') }}"
           class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md hover:border-red-200 transition group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center group-hover:bg-gray-600 transition">
                    <svg class="w-6 h-6 text-gray-600 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Journal d'activité</h3>
                    <p class="text-sm text-gray-500">Consulter l'historique</p>
                </div>
            </div>
        </a>

        {{-- CREATE USER --}}
        <a href="{{ route('superadmin.users.create') }}"
           class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md hover:border-red-200 transition group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-600 transition">
                    <svg class="w-6 h-6 text-green-600 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Nouvel utilisateur</h3>
                    <p class="text-sm text-gray-500">Créer un compte</p>
                </div>
            </div>
        </a>
    </div>

    {{-- SYSTEM OVERVIEW --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Aperçu du système</h3>
                <p class="text-sm text-gray-600">Vue d'ensemble des activités</p>
            </div>
            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- SYSTEM INFO --}}
            <div class="p-4 bg-gray-50 rounded-lg">
                <h4 class="font-semibold text-gray-900 mb-4">Informations système</h4>
                <div class="space-y-3">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Total utilisateurs</span>
                        <span class="font-semibold text-gray-900">{{ $totalUsers }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Gérants</span>
                        <span class="font-semibold text-orange-600">{{ $totalGerants }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Vendeurs</span>
                        <span class="font-semibold text-blue-600">{{ $totalVendeurs }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm border-t border-gray-200 pt-3">
                        <span class="text-gray-600">Comptes actifs</span>
                        <span class="font-semibold text-green-600">{{ $activeUsers }}</span>
                    </div>
                </div>
            </div>

            {{-- STOCK INFO --}}
            <div class="p-4 bg-gray-50 rounded-lg">
                <h4 class="font-semibold text-gray-900 mb-4">État des stocks</h4>
                <div class="space-y-3">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Produits en rupture</span>
                        <span class="font-semibold text-orange-600">{{ $lowStock }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Ventes aujourd'hui</span>
                        <span class="font-semibold text-red-600">{{ $todaySales }}</span>
                    </div>
                    @if($lowStock > 0)
                        <div class="mt-4 p-3 bg-orange-50 border border-orange-200 rounded-lg">
                            <div class="flex gap-2">
                                <svg class="w-5 h-5 text-orange-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <div>
                                    <p class="text-xs font-semibold text-orange-800">Attention</p>
                                    <p class="text-xs text-orange-700">{{ $lowStock }} produit(s) nécessitent un réapprovisionnement</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
