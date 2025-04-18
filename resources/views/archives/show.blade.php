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
            <p class="text-gray-600 mt-2"><strong class="text-gray-800">Fichier :</strong> {{ $archive->fichier }}</p><a href="{{ asset($archive->fichier) }}" target="_blank">Voir le fichier</a>
            <p class="text-gray-600 mt-2"><strong class="text-gray-800">Date de création :</strong> {{ $archive->created_at->format('d/m/Y') }}</p>
        </div>
        
        <div class="mt-6">
           
            <a href="{{ route('archives.telecharger', $archive->id) }}" 
   class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded">
    Télécharger le fichier
</a>
        </div>
    </div>
</div>
@endsection
