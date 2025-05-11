@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white rounded shadow">
    <h1 class="text-xl font-bold mb-4">Archives Gelées à Supprimer</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($archivesObsoletes->isEmpty())
        <p class="text-gray-500">Aucune archive gelée à supprimer.</p>
    @else
        <form action="{{ route('archives.gel.supprimer') }}" method="POST" onsubmit="return confirm('Confirmer la suppression de toutes les archives obsolètes ?')">
            @csrf
            @method('DELETE')

            <table class="w-full border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 text-left">Titre</th>
                        <th class="p-2 text-left">Date de gel</th>
                        <th class="p-2 text-left">Durée (jours)</th>
                        <th class="p-2 text-left">Motif</th>
                        <th class="p-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($archivesObsoletes as $archive)
                        <tr class="border-t">
                            <td class="p-2">{{ $archive->titre }}</td>
                            <td class="p-2">{{ $archive->gel->deleted_at }}</td>
                            <td class="p-2">{{ $archive->gel->duree }}</td>
                            <td class="p-2">{{ $archive->gel->motif }}</td>
                            <td>
                           
                        <form action="{{ route('archives.destroy', $archive->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Confirmer la suppression ?')" class="text-red-500 hover:text-red-700" title="Supprimer">   <i class="fas fa-trash text-red-500 fa-lg" ></i></button>
                        </form>
                               
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <button type="submit" onclick="return confirm('Confirmer la suppression de toutes les archives Obsolètes ?')" class="mt-4 bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                Supprimer les Archives Obsolètes
            </button>
        </form>
    @endif
</div>
@endsection
