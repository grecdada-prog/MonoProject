@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-6">Modifier utilisateur</h1>

<form method="POST" action="{{ route('superadmin.users.update', $user) }}" class="bg-white p-6 rounded shadow-lg w-full md:w-1/2">
    @csrf

    <label class="block mb-2 font-semibold">Nom</label>
    <input type="text" name="name" value="{{ $user->name }}" class="w-full border rounded px-3 py-2 mb-4">

    <label class="block mb-2 font-semibold">Nom utilisateur</label>
    <input type="text" name="username" value="{{ $user->username }}" class="w-full border rounded px-3 py-2 mb-4">

    <label class="block mb-2 font-semibold">Email</label>
    <input type="email" name="email" value="{{ $user->email }}" class="w-full border rounded px-3 py-2 mb-4">

    <label class="block mb-2 font-semibold">Rôle</label>
    <select name="role" class="w-full border rounded px-3 py-2 mb-4">
        <option value="gerant" @selected($user->hasRole('gerant'))>Gérant</option>
        <option value="vendeur" @selected($user->hasRole('vendeur'))>Vendeur</option>
    </select>

    <button class="px-4 py-2 bg-smartblack text-white rounded hover:bg-gray-900">
        Mettre à jour
    </button>

</form>

@endsection
