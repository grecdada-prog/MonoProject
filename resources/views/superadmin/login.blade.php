<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin - SmartStock</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-black flex items-center justify-center min-h-screen p-6">

    {{-- Background Animated Grid --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute inset-0 bg-gradient-to-br from-red-900/10 via-transparent to-gray-900/20"></div>
        <div class="absolute top-0 left-0 w-full h-full"
             style="background-image: radial-gradient(circle at 25px 25px, rgba(220, 38, 38, 0.05) 2%, transparent 0%); background-size: 50px 50px;"></div>
    </div>

    <div class="relative bg-white w-full max-w-md shadow-2xl rounded-3xl p-10 border-2 border-red-100">

        {{-- Logo & Title --}}
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-red-600 to-red-700 rounded-2xl mb-4 shadow-lg">
                <svg class="w-9 h-9 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                </svg>
            </div>
            <h1 class="text-3xl font-extrabold text-gray-900 mb-2">
                Connexion <span class="text-red-600">Super Admin</span>
            </h1>
            <p class="text-gray-500 text-sm font-medium">
                Accès administrateur système
            </p>
        </div>

        {{-- ERRORS --}}
        @if($errors->any())
            <div class="bg-red-50 border-2 border-red-200 text-red-700 px-5 py-4 rounded-xl mb-6 flex items-start gap-3">
                <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <span class="text-sm font-medium">{{ $errors->first() }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('superadmin.login.submit') }}" class="space-y-6">
            @csrf

            {{-- Identifier Input --}}
            <div>
                <label for="identifier" class="block text-sm font-semibold text-gray-700 mb-2">
                    Email ou nom d'utilisateur
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <input type="text"
                           name="identifier"
                           id="identifier"
                           value="{{ old('identifier') }}"
                           class="w-full pl-11 pr-4 py-3.5 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition duration-200 text-gray-900"
                           placeholder="admin@smartstock.com"
                           required
                           autofocus>
                </div>
            </div>

            {{-- Password Input --}}
            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                    Mot de passe
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <input type="password"
                           name="password"
                           id="password"
                           class="w-full pl-11 pr-4 py-3.5 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition duration-200 text-gray-900"
                           placeholder="••••••••"
                           required>
                </div>
            </div>

            {{-- Security Notice --}}
            <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 flex items-start gap-3">
                <svg class="w-5 h-5 text-gray-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="text-xs text-gray-600">
                    <p class="font-semibold mb-1">Accès sécurisé</p>
                    <p>Connexion réservée aux super administrateurs. Toutes les actions sont enregistrées et auditées.</p>
                </div>
            </div>

            {{-- Submit Button --}}
            <button type="submit"
                    class="w-full py-4 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-xl font-semibold shadow-lg hover:from-red-700 hover:to-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-600 transition duration-200 transform hover:scale-[1.02] active:scale-[0.98]">
                <span class="flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    Connexion Sécurisée
                </span>
            </button>
        </form>

        {{-- Back Link --}}
        <div class="mt-8 pt-6 border-t border-gray-200">
            <a href="{{ route('login.mix') }}"
               class="flex items-center justify-center gap-2 text-sm text-gray-600 hover:text-gray-800 transition group">
                <svg class="w-4 h-4 transition group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Retour à la connexion Gérant / Vendeur
            </a>
        </div>

    </div>

</body>
</html>
