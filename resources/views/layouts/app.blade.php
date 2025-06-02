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
    
    <!-- Styles -->
    <style>
        /* Coller ici le contenu complet de votre fichier resources/css/app.css */
        @tailwind base;
        @tailwind components;
        @tailwind utilities;
        
        /* Ajoutez vos styles personnalisés si nécessaire */
        .your-custom-class {
            /* styles */
        }
    </style>

    <!-- Scripts -->
               @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="//unpkg.com/alpinejs" defer></script>
</head>
    <body class="font-sans antialiased bg-gray-100">
        <div class="flex h-screen overflow-hidden">
            <!-- Sidebar -->
            <aside class="w-64 bg-gray-800 text-white flex-shrink-0 h-screen fixed top-0 left-0 z-40 overflow-y-auto">
          
                <div class="p-6">
                    <!-- Title dynamically set to application name -->
                    <x-application-logoblanc class="w-20 h-20 fill-current text-gray-500" />
                    <h2 class="text-lg font-semibold">{{ config('app.name', 'SGAE') }}</h2>
                </div>
                <nav class="flex-1 mt-4 space-y-1 px-2">
                    @php $route = Route::currentRouteName(); @endphp

                    <a href="{{ route('Accueil') }}" class="block px-4 py-2 rounded hover:bg-gray-700 transition {{ $route === 'Accueil' ? 'bg-gray-700 font-semibold' : '' }}">
                        <i class="fas fa-home mr-2"></i> Accueil
                    </a>

                    <a href="{{ route('dashboard') }}"
                    class="block px-4 py-2 rounded hover:bg-gray-700 transition 
                            {{ $route === 'dashboard' ? 'bg-gray-700 font-semibold' : '' }}">
                        <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                    </a>

                    <a href="{{ route('archives.index') }}"
                    class="block px-4 py-2 rounded hover:bg-gray-700 transition 
                            {{ $route === 'archives.index' ? 'bg-gray-700 font-semibold' : '' }}">
                        <i class="fas fa-archive mr-2"></i> Archives
                    </a>

                    <!-- Menu Paramètres -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="w-full text-left flex items-center px-4 py-2 rounded hover:bg-gray-700 transition">
                            <i class="fas fa-cogs mr-2"></i>
                            <span>Paramètres</span>
                            <svg class="w-4 h-4 ml-auto transform transition-transform" :class="{ 'rotate-90': open }"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>

                        <div x-show="open" @click.away="open = false" x-transition
                            class="mt-1 ml-4 space-y-1 bg-gray-900 rounded shadow-lg border border-gray-700 z-50">

                            <a href="{{ route('settings.services') }}"
                            class="block px-4 py-2 hover:bg-gray-700 rounded transition
                                    {{ $route === 'settings.services' ? 'bg-gray-700 font-semibold' : '' }}">
                                Organisation des services
                            </a>
                            <a href="{{ route('settings.archives') }}"
                            class="block px-4 py-2 hover:bg-gray-700 rounded transition
                                    {{ $route === 'settings.archives' ? 'bg-gray-700 font-semibold' : '' }}">
                                Gestion des profils d'archives
                            </a>
                            <a href="{{ route('settings.regles') }}"
                            class="block px-4 py-2 hover:bg-gray-700 rounded transition
                                    {{ $route === 'settings.regles' ? 'bg-gray-700 font-semibold' : '' }}">
                                Gestion du stockage
                            </a>
                            <a href="{{ route('settings.roles') }}"
                            class="block px-4 py-2 hover:bg-gray-700 rounded transition
                                    {{ $route === 'settings.roles' ? 'bg-gray-700 font-semibold' : '' }}">
                                Gestion des rôles
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('users.index') }}"
                    class="block px-4 py-2 rounded hover:bg-gray-700 transition 
                            {{ $route === 'users.index' ? 'bg-gray-700 font-semibold' : '' }}">
                        <i class="fas fa-users mr-2"></i> Gestion des utilisateurs
                    </a>

                    <a href="{{ route('profile.edit') }}"
                    class="block px-4 py-2 rounded hover:bg-gray-700 transition 
                            {{ $route === 'profile.edit' ? 'bg-gray-700 font-semibold' : '' }}">
                        <i class="fas fa-user mr-2"></i> Profil
                    </a>
                 

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="w-full text-left block px-4 py-2 rounded hover:bg-gray-700 transition">
                            <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
                        </button>
                    </form>
                </nav>

            </aside>

            <!-- Main Content -->
            <div class="flex-1 ml-64 overflow-y-auto">
                <!-- Top Navigation -->
                <header class="bg-white shadow sticky top-0 z-30">
                    <div class=" text-right max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        @php
                            $user = Auth::user();
                        @endphp
                        @if($user)
                            <h1 > <strong> Bienvenue M. 
                                {{$user->name}}</strong></h1>
                        @else
                        connectez Vous!
                        @endif
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