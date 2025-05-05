@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h2 class="text-xl font-bold mb-4">Modifier l'Archive</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Formulaire de modification d'archive -->
    <form method="POST" action="{{ route('archives.update', $archive->id) }}" class="mb-4 space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label for="title" class="block text-sm font-medium text-gray-700">Titre</label>
            <input type="text" name="title" id="title" value="{{ old('title', $archive->title) }}" class="border p-2 w-full" required>
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" id="description" rows="4" class="border p-2 w-full" required>{{ old('description', $archive->description) }}</textarea>
        </div>

        <div>
            <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
            <input type="date" name="date" id="date" value="{{ old('date', $archive->date->format('Y-m-d')) }}" class="border p-2 w-full" required>
        </div>

        <div>
            <label for="file" class="block text-sm font-medium text-gray-700">Fichier (optionnel)</label>
            <input type="file" name="file" id="file" class="border p-2 w-full">
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2">Mettre à jour</button>
    </form>

    <hr class="my-4">

    <h2 class="text-lg font-bold mb-4">Liste des Archives</h2>
    <table class="table-auto w-full">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2">Titre</th>
                <th class="p-2">Date</th>
                <th class="p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($archives as $archive)
            <tr class="border-b">
                <td class="p-2">{{ $archive->title }}</td>
                <td class="p-2">{{ $archive->date->format('d/m/Y') }}</td>
                <td class="p-2 space-x-2">
                    <a href="{{ route('archives.edit', $archive->id) }}" class="text-blue-500">Modifier</a>
                    <form action="{{ route('archives.destroy', $archive->id) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Confirmer la suppression ?')" class="text-red-500">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection