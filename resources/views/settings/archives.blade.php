@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-center">Créer un Profil d'Archive</h2>
 @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="bg-green-100 text-red-800 p-4 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
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
            <select name="regles_id" class="w-full border p-2 mb-2" required>
                <option value="">-- Sélectionnez un regle de conservation --</option>
                @foreach($regles as $regle)
                    <option value="{{ $regle->id }}">{{ $regle->nom }}
                        
                    </option>
                @endforeach
            </select>
            <select name="statut" class="w-full border p-2 mb-2" required>
                <option value="1">Actif</option>
                <option value="0">Inactif</option>
            </select>
        </div>

        <!-- Ajout dynamique de champs -->
        <h3 class="text-xl font-bold mb-2">Champs personnalisés (caracteristiques de l'archive)</h3>
        <div id="champs-container" class="mb-4"></div>

        <button type="button" onclick="ajouterChamp()" class="bg-green-500 text-white px-3 py-1 rounded mb-4">➕ Ajouter un champ</button>

        <div class="text-right">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Créer Profil d'archive</button>
        </div>
    </form>
</div>
<h2 class="text-2xl font-bold mt-8 mb-4"><strong>({{ $totalProfiles }})</strong> Profils d'archives existants </h2>

<table class="w-full table-auto border-collapse border border-gray-300">
    <thead class="bg-gray-100">
        <tr>
            <th class="border px-4 py-2">Nom du profil</th>
            <th class="border px-4 py-2">Statut</th>
            <th class="border px-4 py-2">Regles de conservation</th>
            <th class="border px-4 py-2">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($archiveTypes as $profile)
        <tr class="hover:bg-gray-50">
            
            <td class="border px-4 py-2">{{ $profile->nom }}</td>

            <!-- Switch de statut -->
            <td class="border px-4 py-2 text-center">
                <form method="POST" action="{{ route('settings.updateTypeStatus', $profile->id) }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="statut" value="0">
                    <input type="checkbox" name="statut" value="1" onchange="this.form.submit()" {{ $profile->statut == 1 ? 'checked' : '' }}>
                </form>
            </td>
            <td class="border px-4 py-2"> {{ $profile->regles_id }}
            </td>

            <!-- Actions -->
            <td class="border px-4 py-2 flex space-x-2 justify-center">
                <!-- Modifier -->
                <button onclick="openEditModal('{{ $profile->id }}')" class="bg-blue-500 text-white px-3 py-1 rounded">Modifier</button>

                <!-- Voir détails -->
                <button onclick="openDetailModal('{{ $profile->id }}')" class="bg-green-500 text-white px-3 py-1 rounded">Voir détails</button>

                <!-- Supprimer -->
                <form method="POST" action="{{ route('settings.deleteArchiveType', $profile->id) }}" onsubmit="return confirm('Confirmer la suppression ?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Confirmer la suppression ?')" class="bg-red-500 text-white px-3 py-1 rounded">Supprimer</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Modal Modifier -->
<div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
    <div class="bg-white p-6 rounded shadow w-1/2">
        <h3 class="text-xl font-bold mb-4">Modifier Profil d'Archive</h3>
        <form id="editProfileForm" method="POST" action="" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-4">
        <label for="editNom" class="block mb-1 font-semibold">Nom du profil :</label>
        <input type="text" id="editNom" name="nom" class="w-full border p-2">
    </div>

    <div class="mb-4">
        <label class="block mb-1 font-semibold">Statut :</label>
        <input type="checkbox" id="editStatut" name="statut">
    </div>
    
    <input type="text" id="editDescription" name="description" class="w-full border p-2 mb-4">

    <label for="editServiceId" class="block mb-1 font-semibold">Service :</label>
    <select id="editServiceId" name="services_id" class="w-full border p-2 mb-4"></select>

    <label for="editRegleId" class="block mb-1 font-semibold">Règle de conservation :</label>
    <select id="editRegleId" name="regles_id" class="w-full border p-2 mb-4"></select>

    <div id="editFieldsContainer" class="mb-4">
        <!-- Champs dynamiques chargés ici -->
    </div>

    <button type="button" onclick="addNewEditField()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Ajouter un champ
    </button>

    <div class="mt-4">
        <button type="submit" class="bg-green-600 hover:bg-green-800 text-white font-bold py-2 px-4 rounded">
            Enregistrer les modifications
        </button>
    </div>
</form>

    </div>
</div>

<!-- Modal Détails -->
<div id="detailModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
    <div class="bg-white p-6 rounded shadow w-1/2">
        <h3 class="text-xl font-bold mb-4">Détails Profil d'Archive</h3>
        <div id="detailContent"></div>
        <div class="flex justify-end mt-4">
            <button onclick="closeDetailModal()" class="bg-gray-500 text-white px-4 py-2 rounded">Fermer</button>
        </div>
    </div>
</div>





<script>

function openEditModal(id) {
    
    fetch(`/archives/${id}`)
        .then(response => response.json())
        .then(data => {
            // Remplir les champs du formulaire
            document.getElementById('editArchiveId').value = data.id;
            document.getElementById('editNom').value = data.nom;
            document.getElementById('editDescription').value = data.description;
            
            // Afficher la règle (par son nom ou sa durée)
            const regleSelect = document.getElementById('editRegleId');
            regleSelect.innerHTML = ''; // reset
            data.regles.forEach(regle => {
                const option = document.createElement('option');
                option.value = regle.id;
                option.textContent = regle.nom + ' - ' + regle.duree + ' jours';
                if (regle.id === data.regle_id) {
                    option.selected = true;
                }
                regleSelect.appendChild(option);
            });

            // Services
            const serviceSelect = document.getElementById('editServiceId');
            serviceSelect.innerHTML = ''; // reset
            data.services.forEach(service => {
                const option = document.createElement('option');
                option.value = service.id;
                option.textContent = service.nom;
                if (service.id === data.service_id) {
                    option.selected = true;
                }
                serviceSelect.appendChild(option);
            });

            // Afficher la modale
            document.getElementById('editModal').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Erreur récupération de l’archive :', error);
            alert('Impossible de charger les données.');
        });
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}

// Ajouter un nouveau champ dynamiquement dans la modification
function addNewEditField() {
    const fieldsContainer = document.getElementById('editFieldsContainer');
    const index = fieldsContainer.children.length;

    const fieldDiv = document.createElement('div');
    fieldDiv.classList.add('mb-2');
    fieldDiv.innerHTML = `
        <label class="block mb-1 font-semibold">Nom du champ :</label>
        <input type="text" name="new_fields[${index}][nom_champ]" title="veuillez entrer le \"nom\" pour designer le nom , \"document\" pour designer un fichier" class="w-full border p-2 mb-2">

        <label class="block mb-1 font-semibold">Type :</label>
        <input type="text" name="new_fields[${index}][type_champ]" class="w-full border p-2 mb-2">

        <label class="block mb-1 font-semibold">Obligatoire :</label>
        <input type="checkbox" name="new_fields[${index}][obligatoire]">
        <hr class="my-3">
        <button type="button" onclick="this.parentElement.remove()" class="bg-red-500 text-white px-3 py-1 rounded">Annuler</button>

    `;
    fieldsContainer.appendChild(fieldDiv);
}



function openDetailModal(id) {
    fetch(`/settings/archive-profile/${id}/fields`)
    .then(response => response.json())
    .then(fields => {
        let html = '<ul class="list-disc pl-5">';
        if (fields.length > 0) {
            fields.forEach(field => {
                html += `<li><strong>${field.nom_champ}</strong> (${field.type_champ}) ${field.obligatoire ? '- Obligatoire' : ''}</li>`;
            });
        } else {
            html += '<li>Aucun champ défini pour ce profil.</li>';
        }
        html += '</ul>';
        document.getElementById('detailContent').innerHTML = html;
        document.getElementById('detailModal').classList.remove('hidden');
    })
    .catch(error => {
        console.error('Erreur chargement détails :', error);
        alert('Erreur de chargement des détails.');
    });
}

function closeDetailModal() {
    document.getElementById('detailModal').classList.add('hidden');
}

function closeDetailModal() {
    document.getElementById('detailModal').classList.add('hidden');
}

function ajouterChamp() {
    const container = document.getElementById('champs-container');
    const champHTML = `
        <div class="flex items-center gap-2 mb-2">
            <input type="text" name="champs[nom_champ][]" title="veuillez entrer **nom** pour designer le nom , **document** pour designer un fichier" placeholder="Nom du champ" class="border p-2 flex-1" required>
            <select name="champs[type_champ][]" class="border p-2 flex-1" required>
                <option value="text">Texte</option>
                <option value="number">Nombre</option>
                <option value="date">Date</option>
                <option value="file">Fichier</option>
            </select>
            <label class="flex items-center">
                <input type="checkbox" name="champs[obligatoire][]" value="1" class="mr-1"> Obligatoire
            </label>
       <button type="button" onclick="this.parentElement.remove()" class="bg-red-500 text-white px-3 py-1 rounded">Annuler</button>

        </div>
    `;
    container.insertAdjacentHTML('beforeend', champHTML);
}
</script>
@endsection
