<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Vérification 2FA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="bg-white w-96 shadow-xl rounded-lg p-6">
    <h1 class="text-2xl font-bold text-center text-smartred mb-4">
        Vérification 2 facteurs
    </h1>

    <p class="text-gray-600 text-sm mb-4">
        Un code à 6 chiffres vous a été envoyé par email. Entrez-le ci-dessous.
    </p>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('twofactor.verify') }}">
        @csrf

        <label class="block mb-2 font-semibold">Code</label>
        <input type="text" name="code"
               class="w-full border rounded px-3 py-2 mb-4"
               placeholder="123456">

        <button class="w-full bg-smartblack text-white py-2 rounded hover:bg-gray-800">
            Valider
        </button>
    </form>
</div>

</body>
</html>
