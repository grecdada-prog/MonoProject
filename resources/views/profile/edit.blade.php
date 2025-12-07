@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-6">Mon profil</h1>

@if (session('success'))
    <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 gap-8">

    {{-- Infos de base --}}
    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data"
          class="bg-white p-6 rounded shadow">
        @csrf

        <div class="mb-4">
            <label class="block font-semibold mb-1">Nom</label>
            <input type="text" name="name" value="{{ $user->name }}" class="w-full border rounded px-3 py-2">
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Nom utilisateur</label>
            <input type="text" name="username" value="{{ $user->username }}" class="w-full border rounded px-3 py-2">
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Email</label>
            <input type="email" name="email" value="{{ $user->email }}" class="w-full border rounded px-3 py-2">
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Téléphone</label>
            <input type="text" name="phone" value="{{ $user->phone }}" class="w-full border rounded px-3 py-2">
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Photo de profil</label>
            @if($user->avatar_path)
                <img src="{{ asset('storage/' . $user->avatar_path) }}" class="w-16 h-16 rounded-full mb-2" alt="Avatar">
            @endif
            <input type="file" name="avatar" class="w-full">
        </div>

        <button class="px-4 py-2 bg-smartblack text-white rounded">Enregistrer</button>
        <hr class="my-6">

<h2 class="text-xl font-bold mb-4">Sécurité (2FA)</h2>

{{-- TOTP SECTION --}}
<div class="bg-gray-50 p-4 rounded-lg border mb-4">

    @if(auth()->user()->totp_enabled)
        <p class="mb-3 text-green-600 font-semibold">
            ✔ Authentification TOTP activée
        </p>

        <form method="POST" action="{{ route('totp.disable') }}">
            @csrf

            <label class="block mb-2 font-semibold">Confirmez votre mot de passe</label>
            <input type="password" name="password"
                   class="w-full border rounded px-3 py-2 mb-3"
                   placeholder="••••••">

            <button class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                Désactiver Google Authenticator
            </button>
        </form>

    @else
        <p class="mb-3 text-gray-600">
            L’authentification TOTP n’est pas activée.
        </p>

        <a href="{{ route('totp.setup') }}"
           class="px-4 py-2 bg-smartblack text-white rounded hover:bg-gray-900">
            Activer Google Authenticator
        </a>
    @endif

</div>

    </form>

    {{-- Mot de passe (sauf vendeur) --}}
    @unless($user->hasRole('vendeur'))

        <form method="POST" action="{{ route('profile.password') }}" class="bg-white p-6 rounded shadow">
            @csrf

            <h2 class="text-lg font-bold mb-4">Changer le mot de passe</h2>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Mot de passe actuel</label>
                <input type="password" name="current_password" class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Nouveau mot de passe</label>
                <input type="password" name="new_password" class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Confirmer le mot de passe</label>
                <input type="password" name="new_password_confirmation" class="w-full border rounded px-3 py-2">
            </div>

            <button class="px-4 py-2 bg-smartblack text-white rounded">
                Mettre à jour le mot de passe
            </button>
        </form>
    @endunless

@endsection
