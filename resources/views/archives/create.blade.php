@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-center">Créer une Archive</h2>

    <form method="POST" action="{{ route('archives.store') }}">
        @csrf

        <!-- Choix du profil d'archive -->
        <div class="mb-4">
            <label class="block mb-2 font-semibold">Profil d'archive</label>
            <select id="archiveProfileSelect" name="archive_profile_id" class="w-full border p-2" required>
                <option value="">-- Sélectionnez un type d'archive --</option>
                @foreach($types as $profile)
                    <option value="{{ $profile->id }}">{{ $profile->nom }}</option>
                @endforeach
            </select>
        </div>

        <!-- Zone pour générer les champs -->
        <div id="dynamicFields" class="mb-4"></div>

        <!-- Bouton -->
        <div class="text-right">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Créer l'Archive</button>
        </div>
    </form>
</div>

<script>
    document.getElementById('archiveProfileSelect').addEventListener('change', function() {
    const profileId = this.value;
    const dynamicFields = document.getElementById('dynamicFields');

    dynamicFields.innerHTML = ''; // Effacer les anciens champs

    if (profileId) {

        fetch(`/settings/archive-profile/${profileId}/fields  `)
            .then(response => response.json())
            .then(fields => {
                fields.forEach(field => {
                    const div = document.createElement('div');
                    div.classList.add('mb-2');

                    let inputHTML = `
                        <label class="block mb-1 font-semibold">${field.nom_champ}${field.obligatoire ? ' *' : ''}</label>
                        <input 
                            type="${field.type_champ}" 
                            name="champs[${field.nom_champ}]" 
                            class="w-full border p-2" 
                            ${field.obligatoire ? 'required' : ''}
                        >
                    `;
                    div.innerHTML = inputHTML;
                    dynamicFields.appendChild(div);
                });
            })
            .catch(error => {
                alert("hello");

                console.error('Erreur chargement champs:', error);
            });
        }
    });
</script>
@endsection
