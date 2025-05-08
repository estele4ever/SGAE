@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Ajouter une Archive</h1>
        <a href="{{ route('archives.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Retour
        </a>
    </div>

    @if ($errors->any())
            <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    <form method="POST" action="{{ route('archives.store') }}" enctype="multipart/form-data">
        @csrf

        <!-- Profil d'archive -->
        <div class="mb-4">
            <label class="block mb-2 font-semibold">Profil d'archive</label>
            <select id="archiveProfileSelect" name="archive_profile_id" class="w-full border p-2" required>
                <option value="">-- Sélectionnez un type d'archive --</option>
                @foreach($types as $profile)
                    <option value="{{ $profile->id }}">{{ $profile->nom }}</option>
                @endforeach
            </select>
        </div>

        <!-- Champs fixes obligatoires -->
        <div class="mb-4">
            <label class="block mb-2 font-semibold">Nom <span class="text-red-600">*</span></label>
            <input type="text" name="nom" class="w-full border p-2" required>
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold">Description <span class="text-red-600">*</span></label>
            <textarea name="description" class="w-full border p-2" rows="3" required></textarea>
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold">Fichier <span class="text-red-600">*</span></label>
            <input type="file" name="fichier" class="w-full border p-2" required>
        </div>

        <!-- Champs dynamiques (selon profil) -->
        <div id="dynamicFields" class="mb-4"></div>

        <!-- Bouton -->
        <div class="text-right">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Créer l'Archive</button>
        </div>
    </form>
</div>

<script>
document.getElementById('archiveProfileSelect').addEventListener('change', function () {
    const profileId = this.value;
    const dynamicFields = document.getElementById('dynamicFields');

    dynamicFields.innerHTML = ''; // Vider les anciens champs

    if (profileId) {
        fetch(`/settings/archive-profile/${profileId}/fields`)
            .then(response => response.json())
            .then(fields => {
                fields.forEach(field => {
                    const div = document.createElement('div');
                    div.classList.add('mb-4');

                    div.innerHTML = `
                        <label class="block mb-1 font-semibold">${field.nom_champ}${field.obligatoire ? ' <span class="text-red-600">*</span>' : ''}</label>
                        <input 
                            type="${field.type_champ}" 
                            name="champs[${field.nom_champ}]" 
                            class="w-full border p-2" 
                            ${field.obligatoire ? 'required' : ''}
                        >
                    `;
                    dynamicFields.appendChild(div);
                });
            })
            .catch(error => {
                alert( 'etes vous connecter?')
                console.error('Erreur chargement champs dynamiques:', error);
            });
    }
});
</script>
@endsection
