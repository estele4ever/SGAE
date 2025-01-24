@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $archive->titre }}</h1>
    <p><strong>Catégorie :</strong> {{ $archive->categorie }}</p>
    <p><strong>Description :</strong> {{ $archive->description }}</p>
    <p><strong>Date de création :</strong> {{ $archive->created_at->format('d/m/Y') }}</p>
    <a href="{{ Storage::url($archive->fichier) }}" class="btn btn-primary" target="_blank">Télécharger le fichier</a>
</div>
@endsection
