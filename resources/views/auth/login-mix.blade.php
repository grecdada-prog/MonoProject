<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion SmartStock</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-gray-50 via-white to-gray-100 flex items-center justify-center min-h-screen p-6">

    {{-- Background Pattern --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-red-100 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-gray-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
    </div>

    <div class="relative bg-white w-full max-w-md shadow-2xl rounded-3xl p-10 border border-gray-100">

        {{-- Logo & Title --}}
        <div class="text-center mb-10">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-2">
                Smart<span class="text-red-600">Stock</span>
            </h1>
            <p class="text-gray-500 text-sm font-medium">
                Portail de connexion
            </p>
        </div>

        {{-- ERRORS --}}
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-xl mb-6 flex items-start gap-3">
                <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <span class="text-sm">{{ $errors->first() }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('login.mix.submit') }}" class="space-y-6">
            @csrf

            {{-- Username Input --}}
            <div>
                <label for="username" class="block text-sm font-semibold text-gray-700 mb-2">
                    Nom d'utilisateur
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <input type="text"
                           name="username"
                           id="username"
                           value="{{ old('username') }}"
                           class="w-full pl-11 pr-4 py-3.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition duration-200 text-gray-900"
                           placeholder="ex: vendeur01"
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
                           class="w-full pl-11 pr-4 py-3.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition duration-200 text-gray-900"
                           placeholder="••••••••"
                           required>
                </div>
            </div>

            {{-- Role Selection --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    Je suis :
                </label>

                <div class="grid grid-cols-2 gap-3">
                    <label class="relative flex items-center justify-center gap-2 p-4 border-2 border-gray-200 rounded-xl cursor-pointer transition duration-200 hover:border-red-300 hover:bg-red-50 group">
                        <input type="radio"
                               name="role"
                               value="gerant"
                               class="sr-only peer"
                               {{ old('role') == 'gerant' ? 'checked' : '' }}>
                        <div class="absolute inset-0 border-2 border-red-600 rounded-xl opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                        <svg class="w-5 h-5 text-gray-600 peer-checked:text-red-600 transition" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm font-medium text-gray-700 peer-checked:text-red-600 peer-checked:font-semibold transition">Gérant</span>
                    </label>

                    <label class="relative flex items-center justify-center gap-2 p-4 border-2 border-gray-200 rounded-xl cursor-pointer transition duration-200 hover:border-red-300 hover:bg-red-50 group">
                        <input type="radio"
                               name="role"
                               value="vendeur"
                               class="sr-only peer"
                               {{ old('role') == 'vendeur' ? 'checked' : '' }}>
                        <div class="absolute inset-0 border-2 border-red-600 rounded-xl opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                        <svg class="w-5 h-5 text-gray-600 peer-checked:text-red-600 transition" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                        </svg>
                        <span class="text-sm font-medium text-gray-700 peer-checked:text-red-600 peer-checked:font-semibold transition">Vendeur</span>
                    </label>
                </div>
                @error('role')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit Button --}}
            <button type="submit"
                    class="w-full py-4 bg-gradient-to-r from-gray-900 to-gray-800 text-white rounded-xl font-semibold shadow-lg hover:from-gray-800 hover:to-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition duration-200 transform hover:scale-[1.02] active:scale-[0.98]">
                Se connecter
            </button>
        </form>

        {{-- Super Admin Link --}}
        <div class="mt-8 pt-6 border-t border-gray-200">
            <a href="{{ route('superadmin.login') }}"
               class="flex items-center justify-center gap-2 text-sm text-red-600 font-semibold hover:text-red-700 transition group">
                <svg class="w-4 h-4 transition group-hover:rotate-12" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                </svg>
                Connexion Super Admin
            </a>
        </div>

    </div>

    <style>
        @keyframes blob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }
            33% {
                transform: translate(30px, -50px) scale(1.1);
            }
            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }
            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
    </style>

</body>
</html>
