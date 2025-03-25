@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-center">Gestion des types d'archives</h2>

    <form method="POST" action="{{ route('settings.addArchiveType') }}" class="mb-8">
        @csrf
        <div class="flex flex-col md:flex-row md:space-x-4">
            <input type="text" name="nom" placeholder="Nom du type d'archive" class="border p-2 flex-1 mb-2 md:mb-0" required>
            <input type="text" name="description" placeholder="Description du type d'archive" class="border p-2 flex-1 mb-2 md:mb-0">
            <select name="services_id" class="border p-1 flex-1 mb-1 md:mb-0" multiple required>
                <option value="">Sélectionnez un ou plusieurs services</option>
                @foreach($services as $service)
                <option value="{{ $service->id }}">{{ $service->nom }}</option>
                @endforeach
            </select>
            <button type="submit" class="ml-0 md:ml-2 bg-blue-500 text-white px-4 py-2 rounded">Ajouter</button>
        </div>
    </form>

    <ul class="list-disc pl-6">
    @foreach($archiveTypes as $type)
    <li class="flex justify-between items-center mb-4 p-2 border-b">
        <div class="flex-1">
            <strong>{{ $type->nom }}</strong> 
            (<span class="text-gray-600">{{ $type->services->pluck('nom')->join(', ') }}</span>)
            <br>
            <span class="text-sm text-gray-500">{{ $type->description }}</span>
        </div>
        <div class="flex space-x-2">
            <!-- Bouton Modifier -->
            <button onclick="openEditModal('{{ $type->id }}', '{{ $type->nom }}', '{{ $type->description }}', '{{ $type->services_id }}')" class="text-blue-500 hover:text-blue-700">Modifier</button>

            <!-- Formulaire de suppression -->
            <form method="POST" action="{{ route('settings.deleteArchiveType', $type->id) }}" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-700">Supprimer</button>
            </form>
        </div>
    </li>
    @endforeach
</ul>
</div>
<!-- MODAL MODIFICATION -->
<div id="editModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-md w-96">
        <h2 class="text-xl font-bold mb-4">Modifier le type d’archive</h2>
        <form method="POST" action="" id="editForm">
    @csrf
    @method('PUT')

    <input type="hidden" name="id" id="edit_id">

    <input type="text" name="nom" id="edit_nom" placeholder="Nom" class="border p-2 w-full mb-2" required>
    <input type="text" name="description" id="edit_description" placeholder="Description" class="border p-2 w-full mb-2">

    <!-- Sélection d'un seul service -->
    <select name="services_id" id="edit_services" class="border p-2 w-full mb-2" required>
        <option value="">Sélectionnez un service</option>
        @foreach($services as $service)
            <option value="{{ $service->id }}">{{ $service->nom }}</option>
        @endforeach
    </select>

    <div class="flex justify-end space-x-2 mt-4">
        <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-400 text-white rounded">Annuler</button>
        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Enregistrer</button>
    </div>
</form>


    </div>
</div>
<script>
    function openEditModal(id, nom, description, services) {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_nom').value = nom;
        document.getElementById('edit_description').value = description;

        // Sélectionner les services liés dans le select
        let select = document.getElementById('edit_services');
        for (let i = 0; i < select.options.length; i++) {
            select.options[i].selected = services.includes(parseInt(select.options[i].value));
        }

        // Modifier l'action du formulaire
        //document.getElementById('editForm').action = "/archives/updateArchiveType/" + id;
        document.getElementById('editForm').action = "{{ route('settings.updateArchiveType', ':id') }}".replace(':id', id);

        // Afficher le modal
        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }
</script>

@endsection
