@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-4xl">
    <a href="{{ route('archives.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-500 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Retour
    </a>
    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $archive->titre }}</h1>

        <div class="mb-4">
            <p class="text-gray-600"><strong class="text-gray-800">Catégorie :</strong> {{ $archive->categorie }}</p>
            <p class="text-gray-600 mt-2"><strong class="text-gray-800">Description :</strong> {{ $archive->description }}</p>
            <p class="text-gray-600 mt-2"><strong class="text-gray-800">Fichier :</strong> {{ $archive->fichier }}</p>
            <strong><a href="{{ asset($archive->fichier) }}" target="_blank">Voir le fichier</a></strong>
            <p class="text-gray-600 mt-2"><strong class="text-gray-800">Date de création :</strong> {{ $archive->created_at->format('d/m/Y') }}</p>
        </div>

        <a href="{{ route('archives.telecharger', $archive->id) }}" 
               class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded mt-4">
               <i class="fas fa-download"></i> 
               Télécharger le fichier
            </a>
            <!-- Bouton pour ouvrir la modale de gel -->
<button onclick="document.getElementById('modalGel').classList.remove('hidden')" 
        class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded mt-4 ml-2">
    Geler l'archive
</button>
        <div class="mt-6">
            @php
                $extension = pathinfo($archive->fichier, PATHINFO_EXTENSION);
            @endphp
            
            @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
                <h2 class="text-lg font-semibold">Aperçu de l'image :</h2>
                <img src="{{ asset($archive->fichier) }}" alt="{{ $archive->titre }}" class="w-full h-auto rounded mt-4">
                
            @elseif(in_array($extension, ['pdf']))
                <h2 class="text-lg font-semibold">Aperçu du PDF :</h2>
                <iframe src="{{ asset($archive->fichier) }}" width="100%" height="500px" class="rounded mt-4"></iframe>
                
            @elseif(in_array($extension, ['xls', 'xlsx']))
                <h2 class="text-lg font-semibold">Aperçu de l'Excel :</h2>
                <iframe src="https://docs.google.com/gview?url={{ asset($archive->fichier) }}&embedded=true" width="100%" height="500px" class="rounded mt-4"></iframe>
                
            @else
                <p class="text-gray-600">Aperçu non disponible pour ce type de fichier.</p>
            @endif


<!-- Modal de gel -->
<div id="modalGel" class="fixed z-10 inset-0 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen bg-gray-900 bg-opacity-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-lg shadow-lg">
            <h2 class="text-xl font-bold mb-4">Geler l'archive</h2>
            <form action="{{ route('archives.geler', $archive->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Motif de gel</label>
                    <input type="text" name="motif" class="w-full border px-3 py-2 rounded shadow-sm" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Durée du gel (en jours)</label>
                    <input type="number" name="duree" class="w-full border px-3 py-2 rounded shadow-sm" required>
                </div>
                <div class="mb-4">
                <select name="statut" class="border p-2 flex-1 mb-2 md:mb-0" required>
                <option value="">Sélectionnez le statut</option>
                <option value="1">Actif</option>
                <option value="0">Inactif</option>
            </select>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="document.getElementById('modalGel').classList.add('hidden')" 
                            class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded">
                        Annuler
                    </button>
                    <button type="submit" 
                            class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded">
                        Confirmer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

        </div>
    </div>
</div>
@endsection