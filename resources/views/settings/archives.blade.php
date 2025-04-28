@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-center">Créer un Profil d'Archive</h2>

    <form method="POST" action="{{ route('settings.addArchiveProfile') }}">
        @csrf
        <!-- Infos principales -->
        <div class="mb-4">
            <input type="text" name="nom" placeholder="Nom du Profil" class="w-full border p-2 mb-2" required>
            <textarea name="description" placeholder="Description" class="w-full border p-2 mb-2"></textarea>
            <select name="services_id" class="w-full border p-2 mb-2" required>
                <option value="">-- Sélectionnez un service --</option>
                @foreach($services as $service)
                    <option value="{{ $service->id }}">{{ $service->nom }}</option>
                @endforeach
            </select>
            <select name="statut" class="w-full border p-2 mb-2" required>
                <option value="1">Actif</option>
                <option value="0">Inactif</option>
            </select>
        </div>

        <!-- Ajout dynamique de champs -->
        <h3 class="text-xl font-bold mb-2">Champs personnalisés</h3>
        <div id="champs-container" class="mb-4"></div>

        <button type="button" onclick="ajouterChamp()" class="bg-green-500 text-white px-3 py-1 rounded mb-4">➕ Ajouter un champ</button>

        <div class="text-right">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Créer Profil</button>
        </div>
    </form>
</div>

<script>
function ajouterChamp() {
    const container = document.getElementById('champs-container');
    const champHTML = `
        <div class="flex items-center gap-2 mb-2">
            <input type="text" name="champs[nom_champ][]" placeholder="Nom du champ" class="border p-2 flex-1" required>
            <select name="champs[type_champ][]" class="border p-2 flex-1" required>
                <option value="text">Texte</option>
                <option value="number">Nombre</option>
                <option value="date">Date</option>
                <option value="file">Fichier</option>
            </select>
            <label class="flex items-center">
                <input type="checkbox" name="champs[obligatoire][]" value="1" class="mr-1"> Obligatoire
            </label>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', champHTML);
}
</script>
@endsection
