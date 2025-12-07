@extends('layouts.app')

@section('title', 'Modifier Magasin')
@section('page-title', 'Modifier le Magasin')

@section('content')
<div class="max-w-3xl mx-auto">

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Modifier le Magasin</h2>
            <p class="text-gray-600 mt-1">{{ $store->name }} - {{ $store->code }}</p>
        </div>

        <a href="{{ route('superadmin.stores.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Retour
        </a>
    </div>

    {{-- FORM --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        <form method="POST" action="{{ route('superadmin.stores.update', $store) }}">
            @csrf

            <div class="space-y-6">
                {{-- Nom du magasin --}}
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nom du Magasin <span class="text-red-600">*</span>
                    </label>
                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name', $store->name) }}"
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition @error('name') border-red-500 @enderror"
                           placeholder="Ex: Magasin Central">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Code --}}
                <div>
                    <label for="code" class="block text-sm font-semibold text-gray-700 mb-2">
                        Code <span class="text-red-600">*</span>
                    </label>
                    <input type="text"
                           id="code"
                           name="code"
                           value="{{ old('code', $store->code) }}"
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition font-mono @error('code') border-red-500 @enderror"
                           placeholder="Ex: BLC001">
                    @error('code')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Adresse --}}
                <div>
                    <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">
                        Adresse
                    </label>
                    <textarea id="address"
                              name="address"
                              rows="2"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition @error('address') border-red-500 @enderror"
                              placeholder="Ex: Rue de la République, Quartier Bonanjo">{{ old('address', $store->address) }}</textarea>
                    @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Ville --}}
                <div>
                    <label for="city" class="block text-sm font-semibold text-gray-700 mb-2">
                        Ville
                    </label>
                    <input type="text"
                           id="city"
                           name="city"
                           value="{{ old('city', $store->city) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition @error('city') border-red-500 @enderror"
                           placeholder="Ex: Douala">
                    @error('city')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Téléphone --}}
                <div>
                    <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                        Téléphone
                    </label>
                    <input type="tel"
                           id="phone"
                           name="phone"
                           value="{{ old('phone', $store->phone) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition @error('phone') border-red-500 @enderror"
                           placeholder="Ex: +237 6 XX XX XX XX">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Format accepté: +237 6XX XXX XXX ou 6XX XXX XXX</p>
                </div>

                {{-- Statut actif --}}
                <div class="flex items-center gap-3">
                    <input type="checkbox"
                           id="is_active"
                           name="is_active"
                           value="1"
                           {{ old('is_active', $store->is_active) ? 'checked' : '' }}
                           class="w-5 h-5 text-red-600 border-gray-300 rounded focus:ring-red-500">
                    <label for="is_active" class="text-sm font-semibold text-gray-700">
                        Magasin actif
                    </label>
                </div>
            </div>

            {{-- INFO BOX --}}
            <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="text-sm text-blue-800">
                        <p class="font-semibold mb-1">Informations</p>
                        <ul class="list-disc list-inside space-y-1 text-blue-700">
                            <li>{{ $store->users_count ?? 0 }} utilisateur(s) associé(s)</li>
                            <li>Créé le {{ $store->created_at->format('d/m/Y à H:i') }}</li>
                            @if($store->updated_at != $store->created_at)
                                <li>Dernière modification le {{ $store->updated_at->format('d/m/Y à H:i') }}</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

            {{-- ACTIONS --}}
            <div class="flex items-center gap-4 mt-8 pt-6 border-t border-gray-200">
                <button type="submit"
                        class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition shadow-lg hover:shadow-xl font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                    </svg>
                    Enregistrer les Modifications
                </button>

                <a href="{{ route('superadmin.stores.index') }}"
                   class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium">
                    Annuler
                </a>
            </div>
        </form>
    </div>

</div>
@endsection
