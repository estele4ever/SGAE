<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SGAE Dashboard') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 flex">
            <!-- Sidebar -->
            <aside class="w-64 bg-gray-800 text-white min-h-screen">
                <div class="p-6">
                    <h2 class="text-lg font-semibold">{{ config('app.name', 'Storage') }}</h2>
                </div>
                <nav class="mt-4">
                    <ul>
                        <li class="px-4 py-2 hover:bg-gray-700">
                            <a href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="px-4 py-2 hover:bg-gray-700">
                            <a href="{{ route('archives.index') }}">Archives</a>
                        </li>
                        <li class="px-4 py-2 hover:bg-gray-700">
                            <a href="{{ route('profile.edit') }}">Profil</a>
                        </li>
                        <li class="px-4 py-2 hover:bg-gray-700">
                            <form method="POST" action="{{ route('logout') }}">
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
