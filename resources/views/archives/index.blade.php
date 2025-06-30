@php
    $user = Auth::user();
@endphp

@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Liste des Archives</h1>
    <div class="flex space-x-2">
        <a href="{{ route('archives.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            + Ajouter une Archive
        </a>
        <a href="{{ route('archives.gel.index') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
            🧊 Gel des Archives
        </a>
    </div>
</div>

    <div class="mb-4">
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
    
    <input type="text" id="searchInput" placeholder="Rechercher une archive..." class="w-full border p-2 rounded" onkeyup="filterArchives()">
</div>

    <div class="bg-white shadow overflow-hidden rounded-lg">
        <table class="min-w-full table-auto border">
            <thead class="bg-gray-200 text-gray-900">
                <tr>
                    <th class="px-4 py-2 text-left">Nom</th>
                    <th class="px-4 py-2 text-left">Profil</th>
                    <th class="px-4 py-2 text-left">Service</th>
                    <th class="px-4 py-2 text-left">Date de création</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($archives as $archive)
                    @if($user->service == "admin")
                        @php
                            $extension = pathinfo($archive->fichier, PATHINFO_EXTENSION);
                            $iconClass = match(strtolower($extension)) {
                                'pdf' => 'fa-file-pdf text-red-600',
                                'doc', 'docx' => 'fa-file-word text-blue-600',
                                'xls', 'xlsx' => 'fa-file-excel text-green-600',
                                'jpg', 'jpeg', 'png' => 'fa-file-image text-yellow-500',
                                'html', 'htm' => 'fa-file-code text-purple-600',
                                'zip' => 'fa-file-archive text-orange-600',
                                default => 'fa-file text-gray-600',
                            };
                        @endphp
                        <tr class="{{ $loop->iteration % 2 === 0 ? 'bg-gray-100' : 'bg-white' }} hover:bg-blue-50">

                            <td class="px-4 py-2">{{ ucwords(strtolower($archive->titre))  }}</td>
                            <td class="px-4 py-2">{{ $archive->type->nom ?? '—' }}</td>
                            <td class="px-4 py-2">{{ $archive->service_id }}</td>
                            <td class="px-4 py-2">{{ $archive->created_at->format('d/m/Y') }}</td>
                            <td class="px-4 py-2 flex items-center space-x-4">
                                <!-- Voir -->
                                <a href="{{ route('archives.show', $archive->id) }}" title="Voir l'archive">
                                    <i class="fas {{ $iconClass }} fa-lg"></i>
                                </a>

                                <!-- Modifier -->
                                <button 
                                    class="text-blue-500" 
                                    onclick="openEditModal('{{ $archive->id }}', '{{ addslashes($archive->titre) }}', '{{ addslashes($archive->description) }}', '{{ $archive->type_id }}')"
                                    title="Modifier l'archive">
                                    <i class="fas fa-pen fa-lg"></i>
                                </button>

                                @php
                                    $gel = DB::table('registre_gels')
                                        ->where('archive_id', $archive->id)
                                        ->where('statut', '1')
                                        ->whereRaw("(created_at + (duree || ' days')::interval) > NOW()")
                                        ->first();
                                @endphp

                                @if (is_null($gel) || !$gel->statut)
                            <form action="{{ route('archives.destroy', $archive->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Confirmer la suppression ?')" class="text-red-500 hover:text-red-700" title="Supprimer">   <i class="fas fa-trash text-red-500 fa-lg" ></i></button>
                            </form>
                                    @else
                                        <button disabled 
                                                class="bg-gray-300 text-gray-500 py-1 px-3 rounded inline-flex items-center cursor-not-allowed" title="Archive gelée">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-1.414 1.414M6 18l12-12M3 12a9 9 0 0115.75-6.5" />
                                            </svg>
                                            Gelée
                                        </button>
                                    @endif
                            </td>
                        </tr>
                    @elseif($user->service == $archive->service_id)
                        @php
                            $extension = pathinfo($archive->fichier, PATHINFO_EXTENSION);
                            $iconClass = match(strtolower($extension)) {
                                'pdf' => 'fa-file-pdf text-red-600',
                                'doc', 'docx' => 'fa-file-word text-blue-600',
                                'xls', 'xlsx' => 'fa-file-excel text-green-600',
                                'jpg', 'jpeg', 'png' => 'fa-file-image text-yellow-500',
                                'html', 'htm' => 'fa-file-code text-purple-600',
                                'zip' => 'fa-file-archive text-orange-600',
                                default => 'fa-file text-gray-600',
                            };
                        @endphp
                        <tr class="{{ $loop->iteration % 2 === 0 ? 'bg-gray-100' : 'bg-white' }} hover:bg-blue-50">

                            <td class="px-4 py-2">{{ ucwords(strtolower($archive->titre))  }}</td>
                            <td class="px-4 py-2">{{ $archive->type->nom ?? '—' }}</td>
                            <td class="px-4 py-2">{{ $archive->service_id }}</td>
                            <td class="px-4 py-2">{{ $archive->created_at->format('d/m/Y') }}</td>
                            <td class="px-4 py-2 flex items-center space-x-4">
                                <!-- Voir -->
                                <a href="{{ route('archives.show', $archive->id) }}" title="Voir l'archive">
                                    <i class="fas {{ $iconClass }} fa-lg"></i>
                                </a>

                                <!-- Modifier -->
                                <button 
                                    class="text-blue-500" 
                                    onclick="openEditModal('{{ $archive->id }}', '{{ addslashes($archive->titre) }}', '{{ addslashes($archive->description) }}', '{{ $archive->type_id }}')"
                                    title="Modifier l'archive">
                                    <i class="fas fa-pen fa-lg"></i>
                                </button>

                                @php
                                    $gel = DB::table('registre_gels')
                                        ->where('archive_id', $archive->id)
                                        ->where('statut', '1')
                                        ->whereRaw("(created_at + (duree || ' days')::interval) > NOW()")
                                        ->first();
                                @endphp

                                @if (is_null($gel) || !$gel->statut)
                            <form action="{{ route('archives.destroy', $archive->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Confirmer la suppression ?')" class="text-red-500 hover:text-red-700" title="Supprimer">   <i class="fas fa-trash text-red-500 fa-lg" ></i></button>
                            </form>
                                    @else
                                        <button disabled 
                                                class="bg-gray-300 text-gray-500 py-1 px-3 rounded inline-flex items-center cursor-not-allowed" title="Archive gelée">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-1.414 1.414M6 18l12-12M3 12a9 9 0 0115.75-6.5" />
                                            </svg>
                                            Gelée
                                        </button>
                                    @endif
                            </td>
                        </tr>
                    @endif
                @endforeach

                @if ($archives->isEmpty())
                    <tr>
                        <td colspan="4" class="px-4 py-4 text-center text-gray-500">Aucune archive trouvée.</td>
                    </tr>
                @endif
            </tbody>
        </table>


        <!-- Modal d'édition -->
        <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg w-full max-w-lg shadow-lg relative">
                <h2 class="text-xl font-bold mb-4">Modifier l'archive</h2>
                <form id="editForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="editTitre" class="block font-semibold">Nom</label>
                        <input type="text" name="titre" id="editTitre" class="w-full border rounded p-2">
                    </div>
                    <div class="mb-4">
                        <label for="editType" class="block font-semibold">Type d'archive</label>
                        <select name="type_id" id="editType" class="w-full border rounded p-2">
                            @foreach($types as $type)
                                <option value="{{ $type->id }}">{{ $type->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="editDescription" class="block font-semibold">Description</label>
                        <textarea name="description" id="editDescription" class="w-full border rounded p-2"></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="editFichier" class="block font-semibold">Fichier (optionnel)</label>
                        <input type="file" name="fichier" id="editFichier" class="w-full">
                    </div>
                    <div class="flex justify-end space-x-4">
                        <button type="button" onclick="closeEditModal()" class="bg-gray-500 text-white px-4 py-2 rounded">Annuler</button>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Enregistrer</button>
                    </div>
                </form>
            </div>
</div>

    </div>

    <script>
    function filterArchives() {
        const input = document.getElementById("searchInput");
        const filter = input.value.toLowerCase();
        const rows = document.querySelectorAll("table tbody tr");

        rows.forEach(row => {
            const nomCell = row.querySelector("td:nth-child(1)");
            const profilCell = row.querySelector("td:nth-child(2)");

            if (nomCell && profilCell) {
                const nomText = nomCell.textContent.toLowerCase();
                const profilText = profilCell.textContent.toLowerCase();

                if (nomText.includes(filter) || profilText.includes(filter)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            }
        });
    }


    // Fonction pour ouvrir le modal d'édition
    function openEditModal(id, titre, description, typeId) {
        document.getElementById('editTitre').value = titre;
        document.getElementById('editDescription').value = description;
        document.getElementById('editType').value = typeId;

        const form = document.getElementById('editForm');
        form.action = `/archives/${id}`; // Assure-toi que cette route existe avec PUT

        document.getElementById('editModal').classList.remove('hidden');
        document.getElementById('editModal').classList.add('flex');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
        document.getElementById('editModal').classList.remove('flex');
    }
</script>

</div>
@endsection
