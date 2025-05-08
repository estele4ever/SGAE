@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h2 class="text-xl font-bold mb-4 ml-40">Liste des rôles <strong>(Total : {{ $totalRole }})</strong></h2>
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    <form method="POST" action="{{ route('settings.addRole') }}" class="mb-4 flex space-x-2">
        @csrf
        <input type="text" name="privilege" placeholder="Nom du privilege" class="border p-2 flex-1" required>
        <button type="submit" class="bg-blue-500 text-white px-4">Ajouter</button>
    </form>

    <table class="table-auto w-full border-collapse border border-gray-300 shadow-md rounded overflow-hidden">
    <thead class="bg-gray-200 text-gray-700">
        <tr>
            <th class="p-3 text-left border">Nom du privilège</th>
            <th class="p-3 text-center border">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($roles as $role)
        <tr class="{{ $loop->iteration % 2 === 0 ? 'bg-gray-100' : 'bg-white' }} hover:bg-blue-50">
            <td class="p-3 border">{{ $role->name }}</td>
            <td class="p-3 border">
                <div class="flex justify-center space-x-2">
                    <!-- Modifier -->
                    <button onclick="openEditModal('{{ $role->id }}', '{{ $role->name }}')" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded shadow" title="Modifier">
                        <i class="fas fa-pen"></i>
                    </button>

                    <!-- Supprimer -->
                    <form action="{{ route('settings.deleteRole', $role->id) }}" method="POST" onsubmit="return confirm('Confirmer la suppression ?')" class="inline">
                        @csrf @method('DELETE')
                        <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded shadow" title="Supprimer">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

</div>

<!-- MODAL MODIFICATION -->
<div id="editModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-md w-96">
        <h2 class="text-xl font-bold mb-4">Modifier le rôle</h2>
        <form method="POST" action="" id="editForm">
            @csrf
            @method('PUT')

            <input type="hidden" name="id" id="edit_id">

            <input type="text" name="name" id="edit_privilege" placeholder="Nom du rôle" class="border p-2 w-full mb-2" required>

            <div class="flex justify-end space-x-2 mt-4">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-400 text-white rounded">Annuler</button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(id, name) {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_privilege').value = name;

        // Modifier l'action du formulaire 
        document.getElementById('editForm').action = "{{ route('settings.updateRole', ':id') }}".replace(':id', id);

        // Afficher le modal
        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }
</script>

@endsection