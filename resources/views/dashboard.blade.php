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
                <h3 class="text-lg font-bold">{{ __("Archives") }}</h3>
                <p>{{ __("Détails sur les archives enregistrées.") }}</p>
            </div>
        </div>
        
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
            <div class="p-6 text-gray-900">
                <h3 class="text-lg font-bold">{{ __("Services") }}</h3>
                <p>{{ __("Informations sur les services disponibles.") }}</p>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
            <div class="p-6 text-gray-900">
                <h3 class="text-lg font-bold">{{ __("Utilisateurs") }}</h3>
                <p>{{ __("Liste des utilisateurs enregistrés.") }}</p>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
            <div class="p-6 text-gray-900">
                <h3 class="text-lg font-bold">{{ __("Types d'Archives") }}</h3>
                <p>{{ __("Types d'archives disponibles dans le système.") }}</p>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
