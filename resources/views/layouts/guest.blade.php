<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SGAE') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Tailwind CSS via CDN as fallback -->
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        
        <!-- Base Styles -->
        <style>
            body {
                font-family: 'Figtree', sans-serif;
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
                color: #111827;
                position: relative;
                min-height: 100vh;
            }
            
            .bg-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-image: url("{{ asset('images/archive.jfif') }}");
                background-size: cover;
                background-position: center;
                opacity: 0.6; /* Ajustez cette valeur pour contrôler la transparence */
                z-index: -1;
            }
            
            .content-container {
                position: relative;
                z-index: 1;
            }
            
            .bg-white {
                background-color: rgba(252, 249, 249, 0.93); /* Fond légèrement transparent */
            }
            
            .shadow-md {
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            }
            
            .sm\:rounded-lg {
                border-radius: 0.5rem;
            }
            
            @media (min-width: 640px) {
                .sm\:max-w-md {
                    max-width: 28rem;
                }
            }
            
            .flex {
                display: flex;
            }
            
            .flex-col {
                flex-direction: column;
            }
            
            .items-center {
                align-items: center;
            }
            
            .justify-center {
                justify-content: center;
            }
            
            .w-full {
                width: 100%;
            }
            
            .pt-6 {
                padding-top: 1.5rem;
            }
            
            .px-6 {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }
            
            .py-4 {
                padding-top: 1rem;
                padding-bottom: 1rem;
            }
            
            .mt-6 {
                margin-top: 1.5rem;
            }
            
            .overflow-hidden {
                overflow: hidden;
            }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <!-- Arrière-plan avec image transparente -->
        <div class="bg-overlay"></div>
        
        <!-- Contenu principal -->
        <div class="content-container min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>