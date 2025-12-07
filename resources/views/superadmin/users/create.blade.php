@extends('layouts.app')

@section('title', 'Nouvel Utilisateur')
@section('page-title', 'Créer un Utilisateur')

@section('content')
<div class="max-w-4xl mx-auto">

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Nouvel Utilisateur</h2>
            <p class="text-gray-600 mt-1">Créer un nouveau compte utilisateur (Super Admin, Gérant ou Vendeur)</p>
        </div>

        <a href="{{ route('superadmin.users.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Retour
        </a>
    </div>

    {{-- FORM --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        <form method="POST" action="{{ route('superadmin.users.store') }}" id="createUserForm">
            @csrf

            <div class="space-y-8">
                {{-- SECTION 1: INFORMATIONS PERSONNELLES --}}
                <div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Informations Personnelles
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- NAME --}}
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nom complet <span class="text-red-600">*</span>
                            </label>
                            <input type="text"
                                   id="name"
                                   name="name"
                                   value="{{ old('name') }}"
                                   required
                                   maxlength="255"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition @error('name') border-red-500 @enderror"
                                   placeholder="Ex: Jean Dupont">
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- USERNAME --}}
                        <div>
                            <label for="username" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nom d'utilisateur <span class="text-red-600">*</span>
                            </label>
                            <input type="text"
                                   id="username"
                                   name="username"
                                   value="{{ old('username') }}"
                                   required
                                   maxlength="255"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition @error('username') border-red-500 @enderror"
                                   placeholder="Ex: jdupont">
                            @error('username')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Le nom d'utilisateur sera utilisé pour la connexion</p>
                        </div>

                        {{-- EMAIL --}}
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                Email <span class="text-red-600">*</span>
                            </label>
                            <input type="email"
                                   id="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition @error('email') border-red-500 @enderror"
                                   placeholder="Ex: jean.dupont@example.com">
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- PHONE --}}
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                Téléphone
                            </label>
                            <input type="tel"
                                   id="phone"
                                   name="phone"
                                   value="{{ old('phone') }}"
                                   maxlength="13"
                                   pattern="6\s?\d{2}\s?\d{2}\s?\d{2}\s?\d{2}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition @error('phone') border-red-500 @enderror"
                                   placeholder="Ex: 6 57 07 75 57"
                                   oninput="formatCameroonPhone(this)">
                            @error('phone')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Format: 6 XX XX XX XX (9 chiffres, commence par 6)</p>
                        </div>
                    </div>
                </div>

                {{-- SECTION 2: SÉCURITÉ --}}
                <div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        Sécurité & Accès
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- PASSWORD --}}
                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                Mot de passe <span class="text-red-600">*</span>
                            </label>
                            <input type="password"
                                   id="password"
                                   name="password"
                                   required
                                   minlength="8"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition @error('password') border-red-500 @enderror"
                                   placeholder="Minimum 8 caractères">
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Doit contenir majuscules, minuscules et chiffres</p>
                        </div>

                        {{-- PASSWORD CONFIRMATION --}}
                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                Confirmer le mot de passe <span class="text-red-600">*</span>
                            </label>
                            <input type="password"
                                   id="password_confirmation"
                                   name="password_confirmation"
                                   required
                                   minlength="8"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition"
                                   placeholder="Confirmez le mot de passe">
                        </div>

                        {{-- ROLE --}}
                        <div>
                            <label for="role" class="block text-sm font-semibold text-gray-700 mb-2">
                                Rôle <span class="text-red-600">*</span>
                            </label>
                            <select id="role"
                                    name="role"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition @error('role') border-red-500 @enderror">
                                <option value="">Sélectionnez un rôle...</option>
                                <option value="super-admin" {{ old('role') == 'super-admin' ? 'selected' : '' }}>Super Admin</option>
                                <option value="gerant" {{ old('role') == 'gerant' ? 'selected' : '' }}>Gérant</option>
                                <option value="vendeur" {{ old('role') == 'vendeur' ? 'selected' : '' }}>Vendeur</option>
                            </select>
                            @error('role')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- STORE (optional) --}}
                        <div>
                            <label for="store_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                Magasin / Block
                            </label>
                            <select id="store_id"
                                    name="store_id"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition @error('store_id') border-red-500 @enderror">
                                <option value="">Aucun magasin assigné</option>
                                @foreach(\App\Models\Store::orderBy('name')->get() as $store)
                                    <option value="{{ $store->id }}" {{ old('store_id') == $store->id ? 'selected' : '' }}>
                                        {{ $store->name }} ({{ $store->code }})
                                    </option>
                                @endforeach
                            </select>
                            @error('store_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Optionnel - pour Gérants et Vendeurs</p>
                        </div>
                    </div>
                </div>

                {{-- INFO BOX --}}
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="text-sm text-gray-700">
                            <p class="font-semibold mb-1">Important</p>
                            <ul class="list-disc list-inside space-y-1">
                                <li>L'email doit être valide et unique dans le système</li>
                                <li>Le mot de passe doit contenir au moins 8 caractères avec majuscules, minuscules et chiffres</li>
                                <li>Les identifiants seront envoyés à l'utilisateur par email</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ACTIONS --}}
            <div class="flex items-center justify-end gap-4 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('superadmin.users.index') }}"
                   class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                    Annuler
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition shadow-lg hover:shadow-xl font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Créer l'utilisateur
                </button>
            </div>
        </form>
    </div>

</div>

<script>
function formatCameroonPhone(input) {
    // Retirer tous les espaces et caractères non numériques
    let value = input.value.replace(/\D/g, '');

    // Limiter à 9 chiffres
    if (value.length > 9) {
        value = value.substring(0, 9);
    }

    // Formater au format "6 XX XX XX XX"
    let formatted = '';
    for (let i = 0; i < value.length; i++) {
        if (i === 1 || i === 3 || i === 5 || i === 7) {
            formatted += ' ';
        }
        formatted += value[i];
    }

    input.value = formatted;
}
</script>
@endsection
