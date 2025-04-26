@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
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

    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Titre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catégorie</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200" id="archiveTable">
                @foreach ($archives as $archive)
                    @php
                        $extension = strtolower(pathinfo($archive->fichier, PATHINFO_EXTENSION));
                        $icon = match($extension) {
                            'jpg', 'jpeg', 'png', 'gif' => '🖼️',
                            'pdf' => '📄',
                            'doc', 'docx' => '📃',
                            'xls', 'xlsx' => '📊',
                            'ppt', 'pptx' => '📽️',
                            'zip', 'rar' => '🗜️',
                            'exe' => '💾',
                            default => '📁',
                        };
                        $gel = DB::table('registre_gels')
                            ->where('archive_id', $archive->id)
                            ->where('statut', 1)
                            ->first();
                    @endphp
                    <tr class="archive-row">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $archive->titre }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $archive->categorie }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $archive->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm flex items-center space-x-2">
                            <a href="{{ route('archives.show', $archive->id) }}" class="text-xl hover:text-indigo-700" title="Voir l'archive">
                                {{ $icon }}
                            </a>
                            @if (!$gel)
                                <form action="{{ route('archives.destroy', $archive->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded inline-flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Supprimer
                                    </button>
                                </form>
                            @else
                                <button disabled class="bg-gray-300 text-gray-500 py-1 px-3 rounded inline-flex items-center cursor-not-allowed" title="Archive gelée">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-1.414 1.414M6 18l12-12M3 12a9 9 0 0115.75-6.5" />
                                    </svg>
                                    Gelée
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- SCRIPT DE RECHERCHE EN TEMPS RÉEL --}}
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
