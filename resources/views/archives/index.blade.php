@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white rounded shadow">
<h1 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7l1.664 14.435a2 2 0 002 1.819h10.672a2 2 0 002-1.819L21 7M5 7h14l-.868-2.874A2 2 0 0016.172 3H7.828a2 2 0 00-1.96 1.126L5 7z" />
        </svg>
        Liste des Archives
    </h1>

    {{-- Champ de recherche --}}
    <div class="mb-4">
        <input type="text" id="searchInput" placeholder="Rechercher une archive..." class="w-full px-4 py-2 border rounded shadow focus:outline-none focus:ring-2 focus:ring-indigo-500">
    </div>

    <a href="{{ route('archives.create') }}" 
       class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded mb-4 inline-flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
        </svg>
        Ajouter une archive
    </a>
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full table-auto border-collapse">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2">Titre</th>
                <th class="border px-4 py-2">Service</th>
                <th class="border px-4 py-2">Date</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200" id="archiveTable">
            @foreach($archives as $archive)
                <tr class="archive-row">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $archive->titre }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $archive->service_id ?? 'Non défini' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $archive->created_at->format('d/m/Y') }}</td>
                    <td class="border px-4 py-2 space-x-2">
                        <a href="{{ route('archives.show', $archive->id) }}" class="text-blue-500 hover:underline">Voir</a>
                        <a href="{{ route('archives.edit', $archive->id) }}" class="text-yellow-500 hover:underline">Modifier</a>
                        <form action="{{ route('archives.destroy', $archive->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Confirmer la suppression ?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-500 hover:underline">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script>
    document.getElementById("searchInput").addEventListener("keyup", function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll("#archiveTable .archive-row");

        rows.forEach(function(row) {
            let text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });
    });
</script>
@endsection
