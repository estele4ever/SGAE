@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ajouter une Archive</h1>
    <form action="{{ route('archives.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="titre">Titre</label>
            <input type="text" name="titre" id="titre" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="categorie">Catégorie</label>
            <input type="text" name="categorie" id="categorie" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="fichier">Fichier</label>
            <input type="file" name="fichier" id="fichier" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success mt-3">Enregistrer</button>
    </form>
</div>
@endsection
