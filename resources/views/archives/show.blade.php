@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-4xl">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $archive->titre }}</h1>
        
        <div class="mb-4">
            <p class="text-gray-600"><strong class="text-gray-800">Catégorie :</strong> {{ $archive->categorie }}</p>
            <p class="text-gray-600 mt-2"><strong class="text-gray-800">Description :</strong> {{ $archive->description }}</p>
            <p class="text-gray-600 mt-2"><strong class="text-gray-800">Fichier :</strong> {{ $archive->fichier }}</p><a href="{{ asset($archive->fichier) }}" target="_blank">Voir le fichier</a>
            <p class="text-gray-600 mt-2"><strong class="text-gray-800">Date de création :</strong> {{ $archive->created_at->format('d/m/Y') }}</p>
        </div>
        
        <div class="mt-6">
            <a href="{{ Storage::url($archive->fichier) }}" 
               class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded"
               target="_blank">
                Télécharger le fichier
            </a>
        </div>
    </div>
</div>
@endsection
