@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-bold mb-4">Gestion des types d'archives</h2>

    <form method="POST" action="{{ route('settings.addArchiveType') }}" class="mb-6">
        @csrf
        <div class="flex">
            <input type="text" name="name" placeholder="Nom du type d'archive" class="border p-2 flex-1">
            <select name="service_id" class="border p-2">
                @foreach($services as $service)
                <option value="{{ $service->id }}">{{ $service->nom }}</option>
                @endforeach
            </select>
            <button type="submit" class="ml-2 bg-blue-500 text-white px-4 py-2 rounded">Ajouter</button>
        </div>
    </form>

    <ul class="list-disc pl-6">
        @foreach($archiveTypes as $type)
        <li class="flex justify-between items-center">
            <span>{{ $type->nom }} ({{ $type->service->nom }})</span>
            <form method="POST" action="{{ route('settings.deleteArchiveType', $type->id) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500">Supprimer</button>
            </form>
        </li>
        @endforeach
    </ul>
</div>
@endsection
