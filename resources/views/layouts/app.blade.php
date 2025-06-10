<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'SGAE') }}</title>
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('images/logo-transparent.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    
    <!-- Custom Styles -->
    <style>
        /* Styles pour mobile */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: fixed;
                height: auto;
                top: 0;
                left: 0;
                z-index: 40;
                display: none; /* Caché par défaut */
                max-height: calc(100vh - 60px);
                overflow-y: auto;
            }
            
            .sidebar-mobile-open {
                display: block;
            }
            
            .main-content {
                margin-left: 0;
                padding-top: 60px; /* Espace pour le header */
            }
            
            .mobile-menu-button {
                display: block;
                position: absolute;
                top: 15px;
                right: 15px;
                z-index: 50;
                width: 40px;
                height: 40px;
                border-radius: 50%;
                background-color: #1a202c;
                color: white;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
                border: none;
                outline: none;
            }
            
            .mobile-menu-button i {
                transition: transform 0.3s ease;
            }
            
            .mobile-menu-button.open i {
                transform: rotate(90deg);
            }
            
            .nav-item-text {
                display: inline;
            }
            
            .header-content {
                padding-right: 60px; /* Espace pour le bouton menu */
            }
        }
        
        /* Styles pour desktop */
        @media (min-width: 769px) {
            .sidebar {
                display: block !important;
            }
            
            .mobile-menu-button {
                display: none !important;
            }
            
            .main-content {
                margin-left: 16rem;
                padding-top: 0;
            }
            
            .header-content {
                padding-right: 0;
            }
        }

        /* Styles globaux */
        body {
            font-family: 'Figtree', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            background-color: #f3f4f6;
        }

        .sidebar {
            background-color: #1f2937;
            color: white;
        }

        .sidebar a:hover {
            background-color: #374151;
        }

        .sidebar a.bg-gray-700 {
            background-color: #374151;
            font-weight: 600;
        }

        header {
            background-color: white;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }
    </style>
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="font-sans antialiased">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar - Desktop -->
        <aside class="sidebar w-64 flex-shrink-0 h-screen fixed top-0 left-0 z-40 overflow-y-auto">
            <div class="p-6">
                <x-application-logoblanc class="w-20 h-20 fill-current text-gray-500" />
                <h2 class="text-lg font-semibold">{{ config('app.name', 'SGAE') }}</h2>
            </div>
            <nav class="flex-1 mt-4 space-y-1 px-2">
                @php $route = Route::currentRouteName(); @endphp

                <a href="{{ route('Accueil') }}" class="block px-4 py-2 rounded hover:bg-gray-700 transition {{ $route === 'Accueil' ? 'bg-gray-700 font-semibold' : '' }}">
                    <i class="fas fa-home mr-2"></i> <span class="nav-item-text">Accueil</span>
                </a>

                <a href="{{ route('dashboard') }}"
                class="block px-4 py-2 rounded hover:bg-gray-700 transition 
                        {{ $route === 'dashboard' ? 'bg-gray-700 font-semibold' : '' }}">
                    <i class="fas fa-tachometer-alt mr-2"></i> <span class="nav-item-text">Tableau de board</span>
                </a>

                <a href="{{ route('archives.index') }}"
                class="block px-4 py-2 rounded hover:bg-gray-700 transition 
                        {{ $route === 'archives.index' ? 'bg-gray-700 font-semibold' : '' }}">
                    <i class="fas fa-archive mr-2"></i> <span class="nav-item-text">Archives</span>
                </a>

                <!-- Menu Paramètres -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="w-full text-left flex items-center px-4 py-2 rounded hover:bg-gray-700 transition">
                        <i class="fas fa-cogs mr-2"></i>
                        <span class="nav-item-text">Paramètres</span>
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
                    <i class="fas fa-users mr-2"></i> <span class="nav-item-text">Gestion des utilisateurs</span>
                </a>

                <a href="{{ route('profile.edit') }}"
                class="block px-4 py-2 rounded hover:bg-gray-700 transition 
                        {{ $route === 'profile.edit' ? 'bg-gray-700 font-semibold' : '' }}">
                    <i class="fas fa-user mr-2"></i> <span class="nav-item-text">Profil</span>
                </a>
             
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full text-left block px-4 py-2 rounded hover:bg-gray-700 transition">
                        <i class="fas fa-sign-out-alt mr-2"></i> <span class="nav-item-text">Déconnexion</span>
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="main-content flex-1 overflow-y-auto">
            <!-- Top Navigation -->
            <header class="shadow sticky top-0 z-30">
                <div class="relative h-16 flex items-center justify-between px-4 sm:px-6 lg:px-8">
                    <div class="header-content text-left w-full">
                        @php
                            $user = Auth::user();
                        @endphp
                        @if($user)
                            <h1 class="text-sm sm:text-base"><strong>Bienvenue M. {{$user->name}}</strong></h1>
                        @else
                            <p>Connectez-vous !</p>
                        @endif
                    </div>
                    <button class="mobile-menu-button" onclick="toggleSidebar()">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-4 sm:p-6">
                @yield('content')
            </main>
        </div>
    </div>  
       <script>
            function toggleSidebar() {
                const sidebar = document.querySelector('.sidebar');
                const button = document.querySelector('.mobile-menu-button');
                
                sidebar.classList.toggle('sidebar-mobile-open');
                button.classList.toggle('open');
                
                // Changer l'icône
                const icon = button.querySelector('i');
                if (sidebar.classList.contains('sidebar-mobile-open')) {
                    icon.classList.remove('fa-bars');
                    icon.classList.add('fa-times');
                } else {
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
            }
            
            // Fermer le sidebar si on clique à l'extérieur
            document.addEventListener('click', function(event) {
                const sidebar = document.querySelector('.sidebar');
                const button = document.querySelector('.mobile-menu-button');
                
                if (window.innerWidth <= 768 && 
                    !sidebar.contains(event.target) && 
                    !button.contains(event.target) &&
                    sidebar.classList.contains('sidebar-mobile-open')) {
                    toggleSidebar();
                }
            });
        </script>
    </body>
</html>