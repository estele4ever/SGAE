@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-center">Organisation des Services (Total : {{ $totalServices }} )</strong> </h2>
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    <!-- Formulaire d'ajout de service -->
    <form method="POST" action="{{ route('settings.addService') }}" class="mb-8">
        @csrf
        <div class="flex flex-col md:flex-row md:space-x-4">
            <input type="text" name="nom" placeholder="Nom du service" class="border p-2 flex-1 mb-2 md:mb-0" required>
            <input type="text" name="description" placeholder="Description" class="border p-2 flex-1 mb-2 md:mb-0" required>
            <select name="statut" class="border p-2 flex-1 mb-2 md:mb-0" required>
                <option value="">Sélectionnez le statut</option>
                <option value="1">Actif</option>
                <option value="0">Inactif</option>
            </select>
            <button type="submit" class="ml-0 md:ml-2 bg-blue-500 text-white px-4 py-2 rounded">Ajouter</button>
        </div>
    </form>

    <!-- Champ de recherche -->
    <div class="mb-4">
        <input type="text" id="searchServiceInput" placeholder="Rechercher un service..." class="w-full px-4 py-2 border rounded shadow focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div>
<!-- Liste des services -->
<table class="min-w-full bg-white border border-gray-300" id="serviceList">
    <thead>
        <tr class="bg-gray-200">
            <th class="px-4 py-2 text-left">Nom du service</th>
            <th class="px-4 py-2 text-left">Description</th>
            <th class="px-4 py-2 text-left">Statut</th>
            <th class="px-4 py-2 text-left">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($services as $service)
        <tr class="border-b service-item">
            <td class="px-4 py-2">{{ $service->nom }}</td>
            <td class="px-4 py-2">{{ $service->description }}</td>
            <td class="px-4 py-2">
                <form method="POST" action="{{ route('settings.updateServiceStatus', $service->id) }}" class="inline">
                    @csrf
                    @method('PATCH')
                    <select name="statut" class="border p-1 pr-8" onchange="this.form.submit()">
                        <option value="1" {{ $service->statut == 1 ? 'selected' : '' }}>✅ Actif</option>
                        <option value="0" {{ $service->statut == 0 ? 'selected' : '' }}>❌ Inactif</option>
                    </select>
                </form>
            </td>
            <td class="px-4 py-2">
                <button onclick="openEditModal('{{ $service->id }}', '{{ $service->nom }}', '{{ $service->description }}', '{{ $service->statut }}')" class="text-blue-500 hover:text-blue-700">Modifier</button>
                <form method="POST" action="{{ route('settings.deleteService', $service->id) }}" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:text-red-700">Supprimer</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>

<!-- 🛠️ MODAL MODIFICATION -->
<div id="editModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-md w-96">
        <h2 class="text-xl font-bold mb-4">Modifier le service</h2>
        <form method="POST" action="" id="editForm">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="edit_id">
            <input type="text" name="nom" id="edit_nom" placeholder="Nom" class="border p-2 w-full mb-2" required>
            <input type="text" name="description" id="edit_description" placeholder="Description" class="border p-2 w-full mb-2">
            
            <select name="statut" class="border p-1 pr-8" id="edit_statut" required>
                <option value="1">✅ Actif</option>
                <option value="0">❌ Inactif</option>
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
    document.getElementById("searchServiceInput").addEventListener("keyup", function() {
        let filter = this.value.toLowerCase();
        let items = document.querySelectorAll("#serviceList .service-item");

        items.forEach(function(item) {
            let text = item.textContent.toLowerCase();
            item.style.display = text.includes(filter) ? "" : "none";
        });
    });

    function openEditModal(id, nom, description, statut) {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_nom').value = nom;
        document.getElementById('edit_description').value = description;
        document.getElementById('edit_statut').value = statut;

        document.getElementById('editForm').action = "{{ route('settings.updateservice', ':id') }}".replace(':id', id);
        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }
</script>

@endsection