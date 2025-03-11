@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-bold mb-4">Organisation des Services</h2>

    <!-- Formulaire d'ajout de service -->
    <form method="POST" action="{{ route('settings.addService') }}" class="mb-6">
        @csrf
        <div class="flex">
            <input type="text" name="name" placeholder="Nom du service" class="border p-2 flex-1">
            <button type="submit" class="ml-2 bg-blue-500 text-white px-4 py-2 rounded">Ajouter</button>
        </div>
    </form>

    <!-- Liste des services -->
    <ul class="list-disc pl-6">
        @foreach($services as $service)
        <li class="flex justify-between items-center">
            <span>{{ $service->nom }}</span>
            <form method="POST" action="{{ route('settings.deleteService', $service->id) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500">Supprimer</button>
            </form>
        </li>
        @endforeach
    </ul>
</div>
@endsection
