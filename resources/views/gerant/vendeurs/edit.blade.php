@extends('layouts.app')

@section('title', 'Modifier un Vendeur')
@section('page-title', 'Modifier Vendeur')

@section('content')
<div class="max-w-3xl mx-auto">

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-4">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($vendeur->name) }}&background=DC2626&color=fff"
                 alt="{{ $vendeur->name }}"
                 class="w-16 h-16 rounded-full border-4 border-gray-200 shadow-md">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Modifier Vendeur</h2>
                <p class="text-gray-600 mt-1">Modifiez les informations de {{ $vendeur->name }}</p>
            </div>
        </div>

        <a href="{{ route('gerant.vendeurs.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Retour
        </a>
    </div>

    {{-- FORM CARD --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-8">
            <form method="POST" action="{{ route('gerant.vendeurs.update', $vendeur) }}" id="updateVendeurForm">
                @csrf

                {{-- STATUS BADGE --}}
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Statut actuel</label>
                    @if($vendeur->is_active)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-100 text-green-800 text-sm font-semibold rounded-full">
                            <span class="w-2 h-2 bg-green-600 rounded-full"></span>
                            Actif
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-red-100 text-red-800 text-sm font-semibold rounded-full">
                            <span class="w-2 h-2 bg-red-600 rounded-full"></span>
                            Inactif
                        </span>
                    @endif
                    <p class="mt-2 text-xs text-gray-500">Utilisez le bouton de basculement dans la liste pour changer le statut</p>
                </div>

                {{-- DIVIDER --}}
                <div class="border-t border-gray-200 my-6"></div>

                {{-- NAME --}}
                <div class="mb-6">
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nom complet <span class="text-red-600">*</span>
                    </label>
                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name', $vendeur->name) }}"
                           required
                           maxlength="255"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition @error('name') border-red-500 @enderror"
                           placeholder="Ex: Jean Dupont">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- USERNAME --}}
                <div class="mb-6">
                    <label for="username" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nom d'utilisateur <span class="text-red-600">*</span>
                    </label>
                    <input type="text"
                           id="username"
                           name="username"
                           value="{{ old('username', $vendeur->username) }}"
                           required
                           maxlength="255"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition @error('username') border-red-500 @enderror"
                           placeholder="Ex: jdupont">
                    @error('username')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Le nom d'utilisateur est utilisé pour la connexion</p>
                </div>

                {{-- EMAIL --}}
                <div class="mb-6">
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                        Email <span class="text-red-600">*</span>
                    </label>
                    <input type="email"
                           id="email"
                           name="email"
                           value="{{ old('email', $vendeur->email) }}"
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition @error('email') border-red-500 @enderror"
                           placeholder="Ex: jean.dupont@example.com">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- PHONE --}}
                <div class="mb-8">
                    <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                        Téléphone
                    </label>
                    <input type="tel"
                           id="phone"
                           name="phone"
                           value="{{ old('phone', $vendeur->phone) }}"
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

                {{-- INFO BOX --}}
                <div class="mb-8 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="text-sm text-blue-800">
                            <p class="font-semibold mb-1">Note</p>
                            <p>Pour modifier le mot de passe du vendeur, demandez-lui de le faire depuis son profil ou créez un nouveau compte.</p>
                        </div>
                    </div>
                </div>

                {{-- METADATA --}}
                <div class="mb-8 p-4 bg-gray-50 border border-gray-200 rounded-lg">
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-600 font-medium mb-1">Créé le</p>
                            <p class="text-gray-900">{{ $vendeur->created_at->format('d/m/Y à H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 font-medium mb-1">Dernière modification</p>
                            <p class="text-gray-900">{{ $vendeur->updated_at->format('d/m/Y à H:i') }}</p>
                        </div>
                    </div>
                </div>

                {{-- ACTIONS --}}
                <div class="flex items-center justify-end gap-4">
                    <a href="{{ route('gerant.vendeurs.index') }}"
                       class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                        Annuler
                    </a>
                    <button type="button"
                            onclick="confirmAction(
                                'Modifier le vendeur',
                                'Êtes-vous sûr de vouloir enregistrer ces modifications pour {{ $vendeur->name }} ?',
                                () => document.getElementById('updateVendeurForm').submit(),
                                { confirmText: 'Modifier', confirmClass: 'bg-red-600 hover:bg-red-700' }
                            )"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition shadow-lg hover:shadow-xl font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
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
