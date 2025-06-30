@php use Carbon\Carbon; @endphp

@extends('layouts.app')


@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white rounded shadow">
    <h1 class="text-xl font-bold mb-4">Archives Obsolètes à Supprimer</h1>
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


    @if($archivesObsoletes->isEmpty())
        <p class="text-gray-500">Aucune archive Obsolètes à supprimer.</p>
    @else
        <form action="{{ route('archives.gel.supprimer') }}" method="POST" onsubmit="return confirm('Confirmer la suppression de toutes les archives obsolètes ?')">
            @csrf
            @method('DELETE')

            <table class="min-w-full table-auto border">
            <thead class="bg-gray-200 text-gray-700">
                <tr>
                    <th class="px-4 py-2 text-left">Nom</th>
                    <th class="px-4 py-2 text-left">Profil</th>
                    <th class="px-4 py-2 text-left">Date de création</th>
                    <th class="px-4 py-2 text-left">Obsolète  depuis </th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($archivesObsoletes as $archive)
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
                    
                    <td class="px-4 py-2">{{ ucwords(strtolower($archive->titre)) }}</td>
                        <td class="px-4 py-2">{{ $archive->type->nom ?? '—' }}</td>
                        <td class="px-4 py-2">{{ $archive->created_at->format('d/m/Y') }}</td>
                        <td class="px-4 py-2">{{ $archive->deleted_at }} </td>
                        <td class="px-4 py-2 flex items-center space-x-4">
                            <!-- Voir -->
                            <a href="{{ route('archives.show', $archive->id) }}" title="Voir l'archive">
                                <i class="fas {{ $iconClass }} fa-lg"></i>
                            </a>

                            <!-- Modifier -->
                           

                            
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

<div class="max-w-6xl mx-auto p-6 bg-white rounded shadow">
    <h1 class="text-xl font-bold mb-4">Archives Gelées</h1>

    

    @if($archivegeler->isEmpty())
        <p class="text-gray-500">Aucune archive gelée.</p>
    @else
            <table class="w-full border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 text-left">Titre</th>
                        <th class="p-2 text-left">Description</th>
                        <th class="p-2 text-left">Motif</th>
                        <th class="p-2 text-left">Fin du gel</th> <!-- Nouvelle colonne -->
                        <th class="p-2 text-left">Actions</th>
                    </tr>
                </thead>
                @foreach($archivegeler as $archive)
                    @php
                        $gel = $archive->gels->first();
                        $dateFinGel = $gel ? Carbon::parse($gel->created_at)->addDays((int)$gel->duree) : null;
                    @endphp
                    <tr class="border-t {{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                        <td class="p-2">{{ ucwords(strtolower($archive->titre)) }}</td>
                        <td class="p-2">{{ $archive->description }}</td>
                        <td class="p-2">{{ $gel->motif ?? '—' }}</td>
                        <td class="p-2">{{ $dateFinGel ? $dateFinGel->format('d/m/Y') : '—' }}</td> <!-- Affichage de la date -->
                        <td class="p-2">
                            <form action="{{ route('archives.degeler', $archive->id) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" 
                                    class="bg-blue-600 text-white py-1 px-3 rounded inline-flex items-center hover:bg-blue-700" 
                                    title="Dégeler l'archive">
                                    Dégeler
                                </button>
                            </form>

                        </td>
                    </tr>
                @endforeach

            </table>

            
    @endif
</div>
@endsection
