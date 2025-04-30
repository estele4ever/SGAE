@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
    <a href="{{ route('archives.index') }}" class="text-sm text-blue-600 hover:underline mb-4 inline-block">← Retour à la liste</a>

    <h1 class="text-2xl font-bold mb-4">{{ $archive->titre }}</h1>

    <div class="mb-2"><strong>Description :</strong> {{ $archive->description }}</div>
    <div class="mb-2"><strong>Service :</strong> {{ $archive->service_id ?? 'Non défini' }}</div>
    <div class="mb-2"><strong>Date de création :</strong> {{ $archive->created_at->format('d/m/Y H:i') }}</div>

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

    <div class="mt-6">
        <strong>Fichier :</strong> 
        @if($archive->fichier)
            <a href="{{ asset($archive->fichier) }}" class="text-blue-600 hover:underline" target="_blank">Télécharger le fichier</a>
        @else
            <span class="text-gray-500 italic">Aucun fichier disponible</span>
        @endif
    </div>
</div>
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


@endsection
