<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
                @extends('layouts.app')

  <!-- @section('content')
<div class="container">
    <h1>Bienvenue sur le Dashboard</h1>
    <p>Gérez vos archives électroniques ici.</p>

    <!-- Bouton pour rediriger vers l'interface d'ajout d'archives --
    <a href="{{ route('archives.create') }}" class="btn btn-primary">Ajouter une archive</a>
</div>
@endsection -->

            </div>
            
        </div>
    </div>
</x-app-layout>
