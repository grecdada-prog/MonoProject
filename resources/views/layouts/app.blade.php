<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SmartStock - @yield('title', 'Gestion Intelligente')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --color-black: #000000;
            --color-white: #ffffff;
            --color-red: #DC2626;
            --color-green: #16A34A;
            --color-gray-50: #F9FAFB;
            --color-gray-100: #F3F4F6;
            --color-gray-200: #E5E7EB;
            --color-gray-800: #1F2937;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-900 antialiased">

<div class="flex min-h-screen" x-data="{ sidebarOpen: true }">

    {{-- SIDEBAR --}}
    <aside :class="sidebarOpen ? 'w-64' : 'w-20'"
           class="bg-black text-white flex flex-col transition-all duration-300 shadow-2xl">

        {{-- LOGO --}}
        <div class="px-6 py-6 border-b border-gray-800">
            <div class="flex items-center justify-between">
                <div x-show="sidebarOpen" x-transition>
                    <div class="text-2xl font-bold tracking-tight">
                        Smart<span class="text-red-600">Stock</span>
                    </div>
                    <div class="text-xs text-gray-400 mt-1">
                        Gestion Intelligente
                    </div>
                </div>
                <button @click="sidebarOpen = !sidebarOpen"
                        class="p-2 hover:bg-gray-800 rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              :d="sidebarOpen ? 'M6 18L18 6M6 6l12 12' : 'M4 6h16M4 12h16M4 18h16'" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- NAVIGATION --}}
        <nav class="flex-1 px-3 py-6 space-y-2 text-sm overflow-y-auto">

            {{-- SUPER ADMIN --}}
            @role('super-admin')
                <div x-show="sidebarOpen" class="uppercase text-gray-400 text-xs px-3 mb-3 font-semibold">
                    Super Admin
                </div>

                <a href="{{ route('superadmin.dashboard') }}"
                   class="flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-gray-800 transition
                          @if(request()->routeIs('superadmin.dashboard')) bg-gray-800 border-l-4 border-red-600 @endif">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span x-show="sidebarOpen" x-transition>Dashboard</span>
                </a>

                <a href="{{ route('superadmin.users.index') }}"
                   class="flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-gray-800 transition
                          @if(request()->routeIs('superadmin.users.*')) bg-gray-800 border-l-4 border-red-600 @endif">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span x-show="sidebarOpen" x-transition>Utilisateurs</span>
                </a>

                <a href="{{ route('superadmin.stores.index') }}"
                   class="flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-gray-800 transition
                          @if(request()->routeIs('superadmin.stores.*')) bg-gray-800 border-l-4 border-red-600 @endif">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <span x-show="sidebarOpen" x-transition>Magasins / Blocks</span>
                </a>

                <a href="{{ route('superadmin.activity.index') }}"
                   class="flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-gray-800 transition
                          @if(request()->routeIs('superadmin.activity.*')) bg-gray-800 border-l-4 border-red-600 @endif">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span x-show="sidebarOpen" x-transition>Audit & Logs</span>
                </a>

                <a href="{{ route('notifications.index') }}"
                   class="flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-gray-800 transition
                          @if(request()->routeIs('notifications.index')) bg-gray-800 border-l-4 border-red-600 @endif">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span x-show="sidebarOpen" x-transition>Notifications</span>
                </a>
            @endrole

            {{-- GERANT --}}
            @role('gerant')
                <div x-show="sidebarOpen" class="uppercase text-gray-400 text-xs px-3 mb-3 mt-6 font-semibold">
                    Gérant
                </div>

                <a href="{{ route('gerant.dashboard') }}"
                   class="flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-gray-800 transition
                          @if(request()->routeIs('gerant.dashboard')) bg-gray-800 border-l-4 border-red-600 @endif">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <span x-show="sidebarOpen" x-transition>Dashboard</span>
                </a>

                <a href="{{ route('gerant.products.index') }}"
                   class="flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-gray-800 transition
                          @if(request()->routeIs('gerant.products.*')) bg-gray-800 border-l-4 border-red-600 @endif">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <span x-show="sidebarOpen" x-transition>Produits & Stock</span>
                </a>

                <a href="{{ route('gerant.supplies.index') }}"
                   class="flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-gray-800 transition
                          @if(request()->routeIs('gerant.supplies.*')) bg-gray-800 border-l-4 border-red-600 @endif">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                    </svg>
                    <span x-show="sidebarOpen" x-transition>Approvisionnement</span>
                </a>

                <a href="{{ route('gerant.vendeurs.index') }}"
                   class="flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-gray-800 transition
                          @if(request()->routeIs('gerant.vendeurs.*')) bg-gray-800 border-l-4 border-red-600 @endif">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span x-show="sidebarOpen" x-transition>Mes Vendeurs</span>
                </a>
            @endrole

            {{-- VENDEUR --}}
            @role('vendeur')
                <div x-show="sidebarOpen" class="uppercase text-gray-400 text-xs px-3 mb-3 mt-6 font-semibold">
                    Vendeur
                </div>

                <a href="{{ route('vendeur.dashboard') }}"
                   class="flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-gray-800 transition
                          @if(request()->routeIs('vendeur.dashboard')) bg-gray-800 border-l-4 border-red-600 @endif">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span x-show="sidebarOpen" x-transition>Dashboard</span>
                </a>

                <a href="{{ route('vendeur.sales.create') }}"
                   class="flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-gray-800 transition bg-red-600 hover:bg-red-700
                          @if(request()->routeIs('vendeur.sales.create')) border-l-4 border-white @endif">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 4v16m8-8H4" />
                    </svg>
                    <span x-show="sidebarOpen" x-transition class="font-semibold">Nouvelle Vente</span>
                </a>

                <a href="{{ route('vendeur.sales.index') }}"
                   class="flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-gray-800 transition
                          @if(request()->routeIs('vendeur.sales.index')) bg-gray-800 border-l-4 border-red-600 @endif">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span x-show="sidebarOpen" x-transition>Mes Ventes</span>
                </a>
            @endrole

        </nav>

        {{-- USER INFO --}}
        <div class="px-4 py-4 border-t border-gray-800">
            <div x-show="sidebarOpen" x-transition class="text-xs text-gray-400">
                Connecté en tant que<br>
                <span class="text-white font-semibold text-sm">{{ auth()->user()->username }}</span>
                <div class="mt-1 text-gray-500">
                    @role('super-admin')<span class="text-red-600">●</span> Super Admin @endrole
                    @role('gerant')<span class="text-blue-600">●</span> Gérant @endrole
                    @role('vendeur')<span class="text-green-600">●</span> Vendeur @endrole
                </div>
            </div>
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <div class="flex-1 flex flex-col">

        {{-- TOPBAR --}}
        <header class="h-20 bg-white shadow-sm flex items-center justify-between px-8 border-b border-gray-200">
            <div class="flex items-center gap-4">
                <h1 class="text-2xl font-bold text-gray-900">
                    @yield('page-title', 'SmartStock')
                </h1>
            </div>

            <div class="flex items-center gap-8">

                {{-- TOTAL VENTES DU JOUR --}}
                @role('gerant|vendeur')
                <div x-data="salesWidget()" x-init="fetchSales()" class="relative">
                    <button @click="fetchSales()"
                            class="flex items-center gap-3 px-4 py-2 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg hover:from-green-600 hover:to-green-700 transition shadow-md">
                        <div class="flex flex-col items-start">
                            <span class="text-xs opacity-90">CA Aujourd'hui</span>
                            <span class="text-lg font-bold" x-text="formatCurrency(totalSales)">0 F</span>
                        </div>
                        <svg class="w-5 h-5" :class="{'animate-spin': loading}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </button>
                </div>
                @endrole

                {{-- NOTIFICATIONS --}}
                <div class="relative">
                    <a href="{{ route('notifications.index') }}"
                       class="relative inline-block p-2.5 rounded-lg">
                        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="absolute top-1 right-1 bg-red-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </a>
                </div>

                {{-- PROFILE DROPDOWN --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                            class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-100 transition duration-200">
                        <img src="{{ auth()->user()->avatar_path
                            ? asset('storage/' . auth()->user()->avatar_path)
                            : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->username) . '&background=DC2626&color=fff' }}"
                             alt="Avatar"
                             class="h-9 w-9 rounded-full object-cover border-2 border-gray-300" />

                        <div class="hidden md:block text-left">
                            <div class="text-sm font-semibold text-gray-900">
                                {{ auth()->user()->name ?? auth()->user()->username }}
                            </div>
                            <div class="text-xs text-gray-500">
                                @role('super-admin')Super Admin @endrole
                                @role('gerant')Gérant @endrole
                                @role('vendeur')Vendeur @endrole
                            </div>
                        </div>

                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open"
                         @click.outside="open = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-56 bg-white shadow-xl rounded-lg py-2 z-50 border border-gray-200">

                        <a href="{{ route('profile.edit') }}"
                           class="flex items-center gap-3 px-4 py-3 text-gray-900 hover:bg-gray-50 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Mon Profil
                        </a>

                        <hr class="my-2 border-gray-200">

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="flex items-center gap-3 w-full text-left px-4 py-3 text-red-600 hover:bg-red-50 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Déconnexion
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </header>

        {{-- ALERTS --}}
        <div id="alert-container" class="fixed top-20 right-6 z-50 space-y-3">
            @if(session('success'))
                <div x-data="{ show: true }"
                     x-init="setTimeout(() => show = false, 5000)"
                     x-show="show"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform translate-x-8"
                     x-transition:enter-end="opacity-100 transform translate-x-0"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="bg-green-600 text-white px-6 py-4 rounded-lg shadow-2xl flex items-center gap-3 max-w-md">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                    <button @click="show = false" class="ml-auto">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div x-data="{ show: true }"
                     x-init="setTimeout(() => show = false, 5000)"
                     x-show="show"
                     x-transition
                     class="bg-red-600 text-white px-6 py-4 rounded-lg shadow-2xl flex items-center gap-3 max-w-md">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span class="font-medium">{{ session('error') }}</span>
                    <button @click="show = false" class="ml-auto">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endif

            @if($errors->any())
                <div x-data="{ show: true }"
                     x-init="setTimeout(() => show = false, 5000)"
                     x-show="show"
                     x-transition
                     class="bg-red-600 text-white px-6 py-4 rounded-lg shadow-2xl max-w-md">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="flex-1">
                            <p class="font-semibold mb-2">Erreurs de validation:</p>
                            <ul class="list-disc list-inside space-y-1 text-sm">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button @click="show = false">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            @endif
        </div>

        {{-- MAIN CONTENT --}}
        <main class="flex-1 p-8 bg-gray-50 overflow-y-auto">
            @yield('content')
        </main>

    </div>
</div>

{{-- MODAL CONFIRMATION GLOBAL --}}
<div x-data="{
        show: false,
        title: '',
        message: '',
        confirmText: 'Confirmer',
        cancelText: 'Annuler',
        confirmCallback: null,
        confirmClass: 'bg-red-600 hover:bg-red-700'
     }"
     @open-confirm-modal.window="
        show = true;
        title = $event.detail.title;
        message = $event.detail.message;
        confirmText = $event.detail.confirmText || 'Confirmer';
        cancelText = $event.detail.cancelText || 'Annuler';
        confirmCallback = $event.detail.onConfirm;
        confirmClass = $event.detail.confirmClass || 'bg-red-600 hover:bg-red-700';
     "
     x-show="show"
     class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
     style="display: none;">

    <div @click.outside="show = false"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform scale-90"
         x-transition:enter-end="opacity-100 transform scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform scale-100"
         x-transition:leave-end="opacity-0 transform scale-90"
         class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6">

        <div class="flex items-start gap-4">
            <div class="flex-shrink-0 w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>

            <div class="flex-1">
                <h3 class="text-lg font-bold text-gray-900 mb-2" x-text="title"></h3>
                <p class="text-gray-600 text-sm leading-relaxed" x-text="message"></p>
            </div>
        </div>

        <div class="mt-6 flex gap-3 justify-end">
            <button @click="show = false"
                    class="px-5 py-2.5 bg-gray-100 text-gray-800 rounded-lg hover:bg-gray-200 font-medium transition">
                <span x-text="cancelText"></span>
            </button>
            <button @click="confirmCallback(); show = false;"
                    :class="confirmClass"
                    class="px-5 py-2.5 text-white rounded-lg font-medium transition">
                <span x-text="confirmText"></span>
            </button>
        </div>
    </div>
</div>

{{-- MODAL INFO GLOBAL --}}
<div id="smartModal"
     class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl p-6 max-w-md w-full shadow-2xl">
        <h2 id="modalTitle" class="font-bold text-xl mb-3 text-gray-900"></h2>
        <p id="modalMessage" class="text-gray-600 mb-6 leading-relaxed"></p>
        <button onclick="closeSmartModal()"
                class="w-full px-4 py-3 bg-black text-white rounded-lg hover:bg-gray-800 font-medium transition">
            OK
        </button>
    </div>
</div>

<script>
    // Modal simple
    function openSmartModal(title, message) {
        document.getElementById('modalTitle').innerHTML = title;
        document.getElementById('modalMessage').innerHTML = message;
        document.getElementById('smartModal').classList.remove('hidden');
    }

    function closeSmartModal() {
        document.getElementById('smartModal').classList.add('hidden');
    }

    // Modal confirmation
    function confirmAction(title, message, onConfirm, options = {}) {
        window.dispatchEvent(new CustomEvent('open-confirm-modal', {
            detail: {
                title: title,
                message: message,
                onConfirm: onConfirm,
                confirmText: options.confirmText || 'Confirmer',
                cancelText: options.cancelText || 'Annuler',
                confirmClass: options.confirmClass || 'bg-red-600 hover:bg-red-700'
            }
        }));
    }

    // Auto-refresh pour widgets
    setInterval(() => {
        const components = document.querySelectorAll("[data-autorefresh='true']");
        components.forEach(async (el) => {
            const url = el.dataset.url;
            if (!url) return;
            try {
                const html = await fetch(url).then(r => r.text());
                el.innerHTML = html;
            } catch (e) {
                console.error('Auto-refresh failed:', e);
            }
        });
    }, 5000);
</script>

<script>
function salesWidget() {
    return {
        totalSales: 0,
        loading: false,

        async fetchSales() {
            this.loading = true;
            try {
                const response = await fetch('{{ route("api.today-sales") }}', {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });
                const data = await response.json();
                this.totalSales = data.total || 0;
            } catch (error) {
                console.error('Erreur lors de la récupération des ventes:', error);
            } finally {
                this.loading = false;
            }
        },

        formatCurrency(value) {
            return new Intl.NumberFormat('fr-FR').format(value) + ' F';
        }
    }
}
</script>

@stack('scripts')

</body>
</html>
