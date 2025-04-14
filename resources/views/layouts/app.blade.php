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

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 flex">
            <!-- Sidebar -->
            <aside class="w-64 bg-gray-800 text-white min-h-screen">
                <div class="p-6">
                    <!-- Title dynamically set to application name -->
                    <h2 class="text-lg font-semibold">{{ config('app.name', 'SGAE') }}</h2>
                </div>
                <nav class="mt-4">
                    <ul>
                    <li class="px-4 py-2 hover:bg-gray-700 flex items-center gap-2">
                            <i class="fas fa-home"></i>
                            <a href="{{ route('Accueil') }}">Acceuil</a>
                        </li>
                        <li class="px-4 py-2 hover:bg-gray-700 flex items-center gap-2">
                            <i class="fas fa-tachometer-alt"></i>
                            <a href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="px-4 py-2 hover:bg-gray-700 flex items-center gap-2">
                            <i class="fas fa-archive"></i>
                            <a href="{{ route('archives.index') }}">Archives</a>
                        </li>

                        <!-- Paramètres avec menu déroulant -->
                        <li class="relative group">
                            <div class="px-4 py-2 hover:bg-gray-700 flex items-center gap-2 cursor-pointer">
                                <i class="fas fa-cogs"></i>
                                <span>Paramètres</span>
                            </div>
                            
                            <!-- Sous-menu qui s'affiche au survol -->
                            <ul class="absolute right-0 w-56 bg-gray-900 shadow-lg hidden group-hover:block mt-1 z-10">
                                
                                <li class="px-4 py-2 hover:bg-gray-700">
                                    <a href="{{ route('settings.services') }}" class="block">Organisation des services</a>
                                </li>
                                <li class="px-4 py-2 hover:bg-gray-700">
                                    <a href="{{ route('settings.archives') }}" class="block">Gestion des types d'archives</a>
                                </li>
                                <li class="px-4 py-2 hover:bg-gray-700">
                                    <a href="{{ route('settings.storage') }}" class="block">Gestion du stockage</a>
                                </li>
                                
                            </ul>
                        </li>

                       
                        <li class="px-4 py-2 hover:bg-gray-700 flex items-center gap-2">
                            <i class="fas fa-users"></i>
                            <a href="{{ route('users.index') }}">Gestion des utilisateurs</a>
                        </li>

                        <li class="px-4 py-2 hover:bg-gray-700 flex items-center gap-2">
                            <i class="fas fa-user"></i>
                            <a href="{{ route('profile.edit') }}">Profil</a>
                        </li>
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
                        @if (isset($header))
                            <h1 class="text-lg font-semibold">{{ $header }}</h1>
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
