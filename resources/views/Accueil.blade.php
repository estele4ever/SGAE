@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- 1. Bannière de Bienvenue --}}
                    <h1 class="font-semibold text-3xl text-indigo-700 leading-tight mb-4">
                        {{ __('Bienvenue sur le Système de Gestion des Archives') }}
                    </h1>

                    <p class="text-gray-600">{{ __('Votre plateforme centralisée pour organiser, rechercher et gérer efficacement vos précieuses archives.') }}</p>
                </div>
            </div>

            {{-- 2. Navigation Principale --}}
            <nav class="mt-8 bg-gray-100 shadow-md rounded-lg p-4">
                <ul class="flex space-x-4">
                    <li><a href="/" class="text-indigo-600 hover:text-indigo-800 font-semibold">{{ __('Accueil') }}</a></li>
                    <li><a href="{{ route('archives.index') }}" class="text-gray-700 hover:text-gray-900">{{ __('Archives') }}</a></li>
                    <li><a href="{{ route('aide') }}" class="text-gray-700 hover:text-gray-900">{{ __('Aide') }}</a></li>
                </ul>
            </nav>

            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- 3. Fonctionnalités Clés --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">{{ __('Fonctionnalités Clés') }}</h2>
                        <ul class="list-disc list-inside text-gray-700">
                            <li>{{ __('Téléchargement facile et sécurisé de vos archives.') }}</li>
                            <li>{{ __('Consultation intuitive des détails de chaque archive.') }}</li>
                            <li>{{ __('Système de recherche avancée pour retrouver rapidement vos documents.') }}</li>
                            <li>{{ __('Gestion complète des utilisateurs et de leurs permissions.') }}</li>
                        </ul>
                    </div>
                </div>

                {{-- 4. Statistiques Rapides --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">{{ __('Statistiques Rapides') }}</h2>
                        <p class="text-gray-700">{{ __('Nombre total d\'archives :') }} <span class="font-semibold">{{ $archiveCount ?? 0 }}</span></p>
                        <p class="text-gray-700">{{ __('Nombre total d\'utilisateurs :') }} <span class="font-semibold">{{ $userCount ?? 0 }}</span></p>
                        <p class="text-gray-700">{{ __('Nombre total de services :') }} <span class="font-semibold">{{ $serviceCount ?? 0 }}</span></p>
                        <p class="text-gray-700">{{ __('Nombre total de profil d\'archives :') }} <span class="font-semibold">{{ $archiveTypeCount ?? 0 }}</span></p>
                    </div>
                </div>
            </div>

           

            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- 6. Ressources et Documentation --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">{{ __('Ressources et Documentation') }}</h2>
                        <ul class="list-disc list-inside text-gray-700">
                            <li><a href="{{ route('aide') }}" class="text-indigo-600 hover:text-indigo-800">{{ __('Guide d\'utilisation') }}</a></li>
                            <li><a href="/" class="text-indigo-600 hover:text-indigo-800">{{ __('FAQ (Foire Aux Questions)') }}</a></li>
                            <li><a href="/" class="text-indigo-600 hover:text-indigo-800">{{ __('Tutoriels Vidéo') }}</a> (Bientôt disponible)</li>
                        </ul>
                    </div>
                </div>

                {{-- 7. Actualités et Mises à Jour --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">{{ __('Actualités et Mises à Jour') }}</h2>
                        <ul class="list-disc list-inside text-gray-700">
                            <li>{{ __('[Date] Nouvelle fonctionnalité : Ajout de la gestion des métadonnées.') }}</li>
                            <li>{{ __('[Date] Mise à jour de sécurité : Correction de vulnérabilités.') }}</li>
                            <li>{{ __('[Date] Amélioration de la performance du système de recherche.') }}</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- 8. Contact et Support --}}
            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">{{ __('Contact et Support') }}</h2>
                    <p class="text-gray-700">{{ __('Pour toute question ou assistance, veuillez contacter :') }}</p>
                    <p class="text-indigo-600">{{ __('Email :') }} <a href="mailto:estelengnemie@gmail.com">estelengnemie@gmail.com</a></p>
                    <p class="text-indigo-600">{{ __('Téléphone :') }} +237 691 XXX 550</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <footer class="bg-gray-200 text-center py-4 mt-8">
        <p class="text-sm text-gray-500">{{ __('© :year Système de gestion des archives. Tous droits réservés.') }}</p>
    </footer>
@endsection

@push('scripts')
    {{-- Vous pouvez ajouter des scripts spécifiques à cette page ici --}}
@endpush