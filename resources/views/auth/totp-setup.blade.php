@extends('layouts.app')

@section('content')

<div class="bg-white p-6 rounded-lg shadow-lg w-full md:w-1/2">

    <h1 class="text-2xl font-bold mb-4">Configurer Google Authenticator</h1>

    <p class="text-gray-600 mb-4">
        Scannez ce QR code avec Google Authenticator (ou Microsoft Authenticator).
    </p>

    <div class="flex justify-center mb-6">
        {!! $qr !!}
    </div>

    <p class="font-mono bg-gray-100 p-2 rounded text-center mb-6">
        Code secret : {{ $secret }}
    </p>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('totp.verify') }}">
        @csrf

        <label class="font-semibold mb-1 block">Entrez le code à 6 chiffres</label>
        <input type="text" name="code" class="w-full border rounded px-3 py-2 mb-4">

        <button class="w-full bg-smartblack text-white py-2 rounded hover:bg-gray-900">
            Activer TOTP
        </button>
    </form>

</div>

@endsection
