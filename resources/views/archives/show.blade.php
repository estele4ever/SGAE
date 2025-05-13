@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
    <a href="{{ route('archives.index') }}" class="text-sm text-blue-600 hover:underline mb-4 inline-block">← Retour à la liste</a>
@if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
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

    <h1 class="text-2xl font-bold mb-4">{{ $archive->titre }}</h1>

    <div class="mb-2"><strong>Description :</strong> {{ $archive->description }}</div>
    <div class="mb-2"><strong>Service :</strong> {{ $archive->service_id ?? 'Non défini' }}</div>
    <div class="mb-2"><strong>Date de création :</strong> {{ $archive->created_at->format('Y/m/d H:i') }}</div>
    <div class="mb-2"><strong>Date de suppression :</strong> {{ $archive->deleted_at }}</div>

    <hr class="my-4">

    <h2 class="text-lg font-semibold">Champs du profil :</h2>
    @php
        $metadata = json_decode($archive->metadata, true);
    @endphp
    @if($metadata)
        <ul class="list-disc pl-6 mt-2 text-gray-700">
            @foreach($metadata as $key => $value)
                <li><strong>{{ $key }}:</strong> {{ $value }}</li>
            @endforeach
        </ul>
    @else
        <p class="text-gray-500 italic">Aucune métadonnée enregistrée.</p>
    @endif
    <button onclick="document.getElementById('modalGel').classList.remove('hidden')" 
        class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded mt-4 ml-2">
    Geler l'archive
</button>
    <div class="mt-6">
        <strong>Fichier :</strong>
        @if($archive->fichier)
            <a href="{{ asset('storage/' . $archive->fichier) }}" class="text-blue-600 hover:underline" target="_blank">Télécharger le fichier</a>
        @else
            <span class="text-gray-500 italic">Aucun fichier disponible</span>
        @endif
    </div>

    <div class="mt-6">
        @php
            $extension = pathinfo($archive->fichier, PATHINFO_EXTENSION);
        @endphp
        
        @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
            <h2 class="text-lg font-semibold">Aperçu de l'image :</h2> {{$archive->fichier}}
            <img src="{{ asset('storage/' . $archive->fichier) }}" alt="{{ $archive->titre }}" class="w-full h-auto rounded mt-4">
            
        @elseif(in_array($extension, ['pdf']))
            <h2 class="text-lg font-semibold">Aperçu du PDF :</h2> {{$archive->fichier}}
            <iframe src="{{ asset('storage/' . $archive->fichier) }}" width="100%" height="500px" class="rounded mt-4"></iframe>
            
        @elseif(in_array($extension, ['xls', 'xlsx']))
            <h2 class="text-lg font-semibold">Aperçu de l'Excel :</h2> {{$archive->fichier}}
            <iframe src="https://docs.google.com/gview?url={{ asset('storage/' . $archive->fichier) }}&embedded=true" width="100%" height="500px" class="rounded mt-4"></iframe>
            
        @elseif(in_array($extension, ['doc', 'docx', 'html', 'htm']))
            <h2 class="text-lg font-semibold">Aperçu du document :</h2> {{$archive->fichier}}
            <iframe src="https://docs.google.com/gview?url={{ asset('storage/' . $archive->fichier) }}&embedded=true" width="100%" height="500px" class="rounded mt-4"></iframe>
            
        @elseif(in_array($extension, ['zip']))
            <p class="text-gray-600">Aperçu non disponible pour les fichiers ZIP. <a href="{{ asset('storage/' . $archive->fichier) }}" class="text-blue-600 hover:underline" target="_blank">Télécharger le fichier</a></p>
            
        @else
            <p class="text-gray-600">Aperçu non disponible pour ce type de fichier.</p>
        @endif
    </div>
</div>

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
@endsection