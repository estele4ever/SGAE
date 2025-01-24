@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des Archives</h1>
    <a href="{{ route('archives.create') }}" class="btn btn-primary">Ajouter une archive</a>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Catégorie</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($archives as $archive)
                <tr>
                    <td>{{ $archive->titre }}</td>
                    <td>{{ $archive->categorie }}</td>
                    <td>{{ $archive->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('archives.show', $archive->id) }}" class="btn btn-info">Voir</a>
                        <form action="{{ route('archives.destroy', $archive->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
