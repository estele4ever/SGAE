<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SGAE') }}</title>
        <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('images/logo-transparent.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Font Awesome -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
        <script src="//unpkg.com/alpinejs" defer></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 flex">
            <!-- Sidebar -->
            <aside class="w-64 bg-gray-800 text-white min-h-screen">
                <div class="p-6">
                    <!-- Title dynamically set to application name -->
                    <x-application-logoblanc class="w-20 h-20 fill-current text-gray-500" />

                    <h2 class="text-lg font-semibold">{{ config('app.name', 'SGAE') }}</h2>
                </div>
                <nav class="mt-4">
                    <ul>
                        
                        <a href="{{ route('Accueil') }}">
                        <li class="px-4 py-2 hover:bg-gray-700 flex items-center gap-2">
                            <i class="fas fa-home"></i>
                            Acceuil
                        </li>
                        </a>
                        
                        <a href="{{ route('dashboard') }}">
                        <li class="px-4 py-2 hover:bg-gray-700 flex items-center gap-2">
                            <i class="fas fa-tachometer-alt"></i>
                            Dashboard
                        </li></a>
                        
                        <a href="{{ route('archives.index') }}">
                        <li class="px-4 py-2 hover:bg-gray-700 flex items-center gap-2">
                            <i class="fas fa-archive"></i>
                            Archives
                        </li></a>

                        <!-- Paramètres avec menu déroulant -->
                        <div x-data="{ open: false }" class="relative inline-block text-left">
    <!-- Bouton -->
    <button @click="open = !open" class="flex items-center gap-2 px-4 py-2 bg-gray-800 text-white hover:bg-gray-700 rounded">
        <i class="fas fa-cogs"></i>
        <span>Paramètres</span>
        <svg class="w-4 h-4 ml-1 transform" :class="open ? 'rotate-90' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
    </button>

    <!-- Menu déroulant -->
    <div 
        x-show="open" 
        @click.away="open = false" 
        x-transition 
        class="absolute right-0 mt-2 w-64 bg-gray-900 text-white rounded-lg shadow-lg border border-gray-700 z-50"
    >
        <a href="{{ route('settings.services') }}" class="block px-4 py-2 hover:bg-gray-700">Organisation des services</a>
        <a href="{{ route('settings.archives') }}" class="block px-4 py-2 hover:bg-gray-700">Gestion des profils d'archives</a>
        <a href="{{ route('settings.regles') }}" class="block px-4 py-2 hover:bg-gray-700">Gestion du stockage</a>
        <a href="{{ route('settings.roles') }}" class="block px-4 py-2 hover:bg-gray-700">Gestion des rôles</a>
    </div>
</div>


<!-- Script ou style Tailwind complémentaire -->
<style>
    .hover-parent:hover .hover-child {
        display: block;
    }
</style>

                        <a href="{{ route('users.index') }}">
                        <li class="px-4 py-2 hover:bg-gray-700 flex items-center gap-2">
                            <i class="fas fa-users"></i>
                            Gestion des utilisateurs
                        </li></a>
                        <a href="{{ route('profile.edit') }}">
                        <li class="px-4 py-2 hover:bg-gray-700 flex items-center gap-2">
                            <i class="fas fa-user"></i>
                            Profil
                        </li></a>
                        <li class="px-4 py-2 hover:bg-gray-700 flex items-center gap-2">
                            <i class="fas fa-sign-out-alt"></i>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="w-full text-left">Déconnexion</button>
                            </form>
                        </li>
                    </ul>
                </nav>
            </aside>

            <!-- Main Content -->
            <div class="flex-1">
                <!-- Top Navigation -->
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        @php
                            $user = Auth::user();
                        @endphp
                        <h1 > <strong> Bienvenue M. {{$user->name}}</strong></h1>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="p-6">
                    @yield('content')
                </main>
            </div>
        </div>
    </body>
</html>
