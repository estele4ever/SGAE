@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-center">Gestion des types d'archives</h2>

    <form method="POST" action="{{ route('settings.addArchiveType') }}" class="mb-8">
        @csrf
        <div class="flex flex-col md:flex-row md:space-x-4">
            <input type="text" name="nom" placeholder="Nom du type d'archive" class="border p-2 flex-1 mb-2 md:mb-0" required>
            <input type="text" name="description" placeholder="Description du type d'archive" class="border p-2 flex-1 mb-2 md:mb-0" required>
            <select name="services_id" class="border p-2 flex-1 mb-2 md:mb-0" required>
                <option value="">Sélectionnez un service</option>
                @foreach($services as $service)
                <option value="{{ $service->id }}">{{ $service->nom }}</option>
                @endforeach
            </select>
            <button type="submit" class="ml-0 md:ml-2 bg-blue-500 text-white px-4 py-2 rounded">Ajouter</button>
        </div>
    </form>

    <ul class="list-disc pl-6">
        @foreach($archiveTypes as $type)
        <li class="flex justify-between items-center mb-4 p-2 border-b">
            <div class="flex-1">
                <strong>{{ $type->nom }}</strong> ({{ $type->service->nom }}) - {{ $type->description }}
            </div>
            <div>
                <form method="POST" action="{{ route('settings.deleteArchiveType', $type->id) }}" class="inline">
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
