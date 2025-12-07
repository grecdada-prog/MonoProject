@extends('layouts.app')

@section('title', 'Historique d\'Activité')
@section('page-title', 'Historique d\'Activité')

@section('content')
<div class="max-w-7xl mx-auto">

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Historique d'Activité</h2>
            <p class="text-gray-600 mt-1">Journal des actions effectuées par vous et vos vendeurs</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('gerant.activity.export.pdf') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
                Export PDF
            </a>

            <a href="{{ route('gerant.activity.export.excel') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Export Excel
            </a>
        </div>
    </div>

    {{-- STATS CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Actions</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $logs->total() }}</p>
                </div>
                <div class="w-14 h-14 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Aujourd'hui</p>
                    <p class="text-3xl font-bold text-green-600">{{ $logs->where('created_at', '>=', today())->count() }}</p>
                </div>
                <div class="w-14 h-14 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Cette Semaine</p>
                    <p class="text-3xl font-bold text-orange-600">{{ $logs->where('created_at', '>=', now()->startOfWeek())->count() }}</p>
                </div>
                <div class="w-14 h-14 bg-orange-100 rounded-lg flex items-center justify-center">
                    <svg class="w-7 h-7 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Ce Mois</p>
                    <p class="text-3xl font-bold text-purple-600">{{ $logs->where('created_at', '>=', now()->startOfMonth())->count() }}</p>
                </div>
                <div class="w-14 h-14 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- FILTERS --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="user" class="block text-sm font-semibold text-gray-700 mb-2">Utilisateur</label>
                <select id="user"
                        name="user"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    <option value="">Tous les utilisateurs</option>
                    <option value="{{ auth()->id() }}" {{ request('user') == auth()->id() ? 'selected' : '' }}>
                        Moi ({{ auth()->user()->name }})
                    </option>
                    @foreach(auth()->user()->sellers as $seller)
                        <option value="{{ $seller->id }}" {{ request('user') == $seller->id ? 'selected' : '' }}>
                            {{ $seller->name }} (Vendeur)
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="action" class="block text-sm font-semibold text-gray-700 mb-2">Action</label>
                <input type="text"
                       id="action"
                       name="action"
                       value="{{ request('action') }}"
                       placeholder="Ex: Créé, Modifié..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
            </div>

            <div>
                <label for="date_from" class="block text-sm font-semibold text-gray-700 mb-2">Du</label>
                <input type="date"
                       id="date_from"
                       name="date_from"
                       value="{{ request('date_from') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
            </div>

            <div>
                <label for="date_to" class="block text-sm font-semibold text-gray-700 mb-2">Au</label>
                <input type="date"
                       id="date_to"
                       name="date_to"
                       value="{{ request('date_to') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
            </div>

            <div class="md:col-span-4 flex items-center gap-2">
                <button type="submit"
                        class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium">
                    Filtrer
                </button>
                <a href="{{ route('gerant.activity.index') }}"
                   class="flex-1 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium text-center">
                    Réinitialiser
                </a>
            </div>
        </form>
    </div>

    {{-- TIMELINE --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6">
            @forelse($logs as $log)
            <div class="flex gap-4 pb-6 {{ !$loop->last ? 'border-b border-gray-200 mb-6' : '' }}">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-full flex items-center justify-center text-white font-bold shadow">
                        {{ strtoupper(substr($log->user->name, 0, 2)) }}
                    </div>
                </div>

                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-4 mb-2">
                        <div>
                            <p class="font-semibold text-gray-900">{{ $log->user->name }}</p>
                            <p class="text-sm text-gray-500">
                                @if($log->user->hasRole('gerant'))
                                    <span class="text-orange-600 font-medium">Gérant</span>
                                @else
                                    <span class="text-blue-600 font-medium">Vendeur</span>
                                @endif
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-900 font-medium">{{ $log->created_at->format('d/m/Y') }}</p>
                            <p class="text-xs text-gray-500">{{ $log->created_at->format('H:i') }}</p>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-900 mb-2">
                            <span class="font-semibold text-red-600">{{ $log->action }}</span>
                        </p>
                        @if($log->description)
                            <p class="text-sm text-gray-600">{{ $log->description }}</p>
                        @endif
                        @if($log->ip_address)
                            <p class="text-xs text-gray-400 mt-2">IP: {{ $log->ip_address }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="py-12 text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <p class="text-gray-600 font-medium">Aucune activité pour le moment</p>
            </div>
            @endforelse
        </div>

        @if($logs->hasPages())
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            {{ $logs->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
