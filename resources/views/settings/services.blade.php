@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-center">Organisation des Services</h2>

    <!-- Formulaire d'ajout de service -->
    <form method="POST" action="{{ route('settings.addService') }}" class="mb-8">
        @csrf
        <div class="flex flex-col md:flex-row md:space-x-4">
            <input type="text" name="nom" placeholder="Nom du service" class="border p-2 flex-1 mb-2 md:mb-0" required>
            <input type="text" name="description" placeholder="Description" class="border p-2 flex-1 mb-2 md:mb-0" required>
            <select name="status" class="border p-2 flex-1 mb-2 md:mb-0" required>
                <option value="">Sélectionnez le statut</option>
                <option value="1">Actif</option>
                <option value="0">Inactif</option>
            </select>
            <button type="submit" class="ml-0 md:ml-2 bg-blue-500 text-white px-4 py-2 rounded">Ajouter</button>
        </div>
    </form>

    <!-- Liste des services -->
    <ul class="list-disc pl-6">
        @foreach($services as $service)
        <li class="flex justify-between items-center mb-4 p-2 border-b">
            <div class="flex-1">
                <strong>{{ $service->nom }}</strong> - {{ $service->description }}
            </div>
            <div>
                <form method="POST" action="{{ route('settings.updateServiceStatus', $service->id) }}" class="inline">
                    @csrf
                    @method('PATCH')
                    <select name="status" class="border p-1" onchange="this.form.submit()">
                        <option value="1" {{ $service->status == 1 ? 'selected' : '' }}>Actif</option>
                        <option value="0" {{ $service->status == 0 ? 'selected' : '' }}>Inactif</option>
                    </select>
                </form>
            </div>
            <div>
                <form method="POST" action="{{ route('settings.deleteService', $service->id) }}" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:text-red-700">Supprimer</button>
                </form>
            </div>
        </li>
        @endforeach
    </ul> 
</div>
@endsection
