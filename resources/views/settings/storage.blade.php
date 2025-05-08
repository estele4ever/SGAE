@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-bold mb-4">Gestion du stockage</h2>
    <p>Espace utilisé : 10 Go</p>

    <progress value="5" max="40" class="w-full"></progress>

    <form method="POST" action="" class="mt-4">
        @csrf
        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Nettoyer les archives obsolètes</button>
    </form>
</div>

<div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-center">Regle de conservation</h2>
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    <!-- Formulaire d'ajout de service -->
    <form method="POST" action="{{ route('settings.addRegle') }}" class="mb-8">
        @csrf
        <div class="flex flex-col md:flex-row md:space-x-4">
            <input type="text" name="nom" placeholder="Nom de la regle de conservation" class="border p-2 flex-1 mb-2 md:mb-0" required>
            <input type="text" name="description" placeholder="Description" class="border p-2 flex-1 mb-2 md:mb-0" required>
            <input type="number" name="duree" id="duree" minlength="0" placeholder="duree">
            <select name="temporalite" class="border p-1 pr-8" id="edit_temporalite" required>
                <option value="1"> Jour</option>
                <option value="2"> Mois</option>
                <option value="3"> Annee</option>
            </select>
            <button type="submit" class="ml-0 md:ml-2 bg-blue-500 text-white px-4 py-2 rounded">Ajouter</button>
        </div>
    </form>

    <!-- Champ de recherche -->
    <div class="mb-4">
        <input type="text" id="searchRegleInput" placeholder="Rechercher une regle..." class="w-full px-4 py-2 border rounded shadow focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div>

    <!-- Liste des regles -->
    <!-- Tableau des règles -->
<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 border" id="regleList">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2 text-left">Nom</th>
                <th class="px-4 py-2 text-left">Description</th>
                <th class="px-4 py-2 text-left">Durée</th>
                <th class="px-4 py-2 text-left">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($regles as $regle)
                <tr class="regle-item odd:bg-gray-100 even:bg-white">
                    <td class="px-4 py-2">{{ $regle->nom }}</td>
                    <td class="px-4 py-2">{{ $regle->description }}</td>
                    <td class="px-4 py-2">
    @php
        $jours = $regle->duree;
        $annees = intdiv($jours, 365);
        $reste = $jours % 365;

        $mois = intdiv($reste, 30);
        $reste %= 30;

        $semaines = intdiv($reste, 7);
        $reste %= 7;

        $affichage = [];
        if ($annees) $affichage[] = "$annees an" . ($annees > 1 ? 's' : '');
        if ($mois) $affichage[] = "$mois mois";
        if ($semaines) $affichage[] = "$semaines semaine" . ($semaines > 1 ? 's' : '');
        if ($reste) $affichage[] = "$reste jour" . ($reste > 1 ? 's' : '');
    @endphp
    {{ implode(' ', $affichage) }}
</td>

                    <td class="px-4 py-2 space-x-2">
                        <button onclick="openEditModal('{{ $regle->id }}', '{{ $regle->nom }}', '{{ $regle->description }}', '{{ $regle->duree }}', '{{ $regle->temporalite }}')" class="text-blue-500 hover:text-blue-700" title="Modifier">  <i class="fas fa-pen fa-lg"></i></button>
                        <form method="POST" action="{{ route('settings.deleteRegle', $regle->id) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Confirmer la suppression ?')" class="text-red-500 hover:text-red-700" title="Supprimer">   <i class="fas fa-trash text-red-500 fa-lg" ></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach

            @if($regles->isEmpty())
                <tr>
                    <td colspan="4" class="text-center py-4 text-gray-500">Aucune règle trouvée.</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

</div>

<!-- 🛠️ MODAL MODIFICATION -->
<div id="editModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-md w-96">
        <h2 class="text-xl font-bold mb-4">Modifier la regle</h2>
        <form method="POST" action="" id="editForm">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="edit_id">
            <input type="text" name="nom" id="edit_nom" placeholder="Nom" class="border p-2 w-full mb-2" required>
            <input type="text" name="description" id="edit_description" placeholder="Description" class="border p-2 w-full mb-2">
            
            <input type="number" name="duree" id="edit_duree" placeholder="duree" class="border p-2 w-full mb-2" required >
            <select name="temporalite" class="border p-1 pr-8" id="edit_temporalite" required>
                <option value="1"> Jour</option>
                <option value="2"> Mois</option>
                <option value="3"> Annee</option>
            </select>
            <div class="flex justify-end space-x-2 mt-4">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-400 text-white rounded">Annuler</button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

{{-- Script JavaScript pour la recherche instantanée --}}
<script>
    document.getElementById("searchRegleInput").addEventListener("keyup", function() {
        let filter = this.value.toLowerCase();
        let items = document.querySelectorAll("#regleList .regle-item");

        items.forEach(function(item) {
            let text = item.textContent.toLowerCase();
            item.style.display = text.includes(filter) ? "" : "none";
        });
    });

    function openEditModal(id, nom, description, duree,temporalite) {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_nom').value = nom;
        document.getElementById('edit_description').value = description;
        document.getElementById('edit_duree').value = duree;
        document.getElementById('edit_temporalite').value = temporalite;

        document.getElementById('editForm').action = "{{ route('settings.updateregle', ':id') }}".replace(':id', id);
        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }
</script>

@endsection
