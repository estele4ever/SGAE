@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Liste des Archives</h1>
        <a href="{{ route('archives.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            + Ajouter une Archive
        </a>

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
    </div>

    <div class="bg-white shadow overflow-hidden rounded-lg">
        <table class="min-w-full table-auto border">
            <thead class="bg-gray-200 text-gray-700">
                <tr>
                    <th class="px-4 py-2 text-left">Nom</th>
                    <th class="px-4 py-2 text-left">Profil</th>
                    <th class="px-4 py-2 text-left">Date de création</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($archives as $archive)
                    @php
                        $extension = pathinfo($archive->fichier, PATHINFO_EXTENSION);
                        $iconClass = match(strtolower($extension)) {
                            'pdf' => 'fa-file-pdf text-red-600',
                            'doc', 'docx' => 'fa-file-word text-blue-600',
                            'xls', 'xlsx' => 'fa-file-excel text-green-600',
                            'jpg', 'jpeg', 'png' => 'fa-file-image text-yellow-500',
                            default => 'fa-file text-gray-600',
                        };
                    @endphp
                    <tr class="border-b odd:bg-gray-100 even:bg-white">
                        <td class="px-4 py-2">{{ $archive->nom }}</td>
                        <td class="px-4 py-2">{{ $archive->type->nom ?? '—' }}</td>
                        <td class="px-4 py-2">{{ $archive->created_at->format('d/m/Y') }}</td>
                        <td class="px-4 py-2 flex items-center space-x-4">
                            <!-- Voir -->
                            <a href="{{ route('archives.show', $archive->id) }}" title="Voir l'archive">
                                <i class="fas {{ $iconClass }} fa-lg"></i>
                            </a>

                            <!-- Modifier -->
                            <a href="{{ route('archives.edit', $archive->id) }}" title="Modifier l'archive">
                                <i class="fas fa-pen text-blue-500 fa-lg"></i>
                            </a>

                            <!-- Supprimer -->
                            <form action="{{ route('archives.destroy', $archive->id) }}" method="POST" onsubmit="return confirm('Confirmer la suppression ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Supprimer l'archive">
                                    <i class="fas fa-trash text-red-500 fa-lg"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach

                @if ($archives->isEmpty())
                    <tr>
                        <td colspan="4" class="px-4 py-4 text-center text-gray-500">Aucune archive trouvée.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

   
</div>
@endsection
