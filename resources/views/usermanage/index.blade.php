@extends('layouts.app')

@section('content')   
 <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">

    <h2 class="text-xl font-bold mb-4">Gestion des utilisateurs</h2>
    
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
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

    <!-- Formulaire d'ajout d'utilisateur -->
    <form method="POST" action="{{ route('users.store') }}" class="mb-4 space-y-4">
        @csrf
        <div>
            <input type="text" name="name" placeholder="Nom" class="border p-2 w-full" required>
        </div>
        <div>
            <input type="email" name="email" placeholder="Email" class="border p-2 w-full" required>
        </div>
        <div>
            <input type="password" name="password" placeholder="Mot de passe" class="border p-2 w-full" required>
        </div>
        <div>
            <input type="password" name="password_confirmation" placeholder="Confirmer le mot de passe" class="border p-2 w-full" required>
        </div>
        <div>
            <select name="role" class="border p-2 w-full" required>
                <option value="" disabled selected>Sélectionnez un rôle</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <select name="service" class="border p-2 w-full" required>
                <option value="" disabled selected>Sélectionnez un service</option>
                @foreach($services as $service)
                    <option value="{{ $service->id }}">{{ $service->nom }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <input type="text" name="permission" placeholder="Permissions (optionnel)" class="border p-2 w-full">
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2">Créer</button>
    </form>

    <!-- Flèche indiquant du contenu en bas -->
    <div class="flex justify-center mb-4">
        <a href="#usersList">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </a>
    </div></div>
    <hr class="my-4">
    <h2 id="usersList" class="text-lg font-bold mb-4">Liste des utilisateurs</h2>
    
    <!-- Formulaire de filtrage -->
    <form method="GET" action="{{ route('users.index') }}" class="mb-4 flex flex-wrap space-x-2">
        <select name="service_id" id="service_id" class="form-select border p-2 flex-1 mb-2">
            <option value="" disabled selected>Tous les services</option>
            @foreach ($services as $service)
                <option value="{{ $service->id }}" {{ request('service_id') == $service->id ? 'selected' : '' }}>
                    {{ $service->nom }}
                </option>
            @endforeach
        </select>
        
        <select name="role" class="border p-2 flex-1 mb-2">
            <option value="" disabled selected>Tous les rôles</option>
            @foreach($roles as $role)
                <option value="{{ $role->id }}" {{ request('role') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
            @endforeach
        </select>
        
        <button type="submit" class="bg-gray-500 text-white px-4 py-2">Filtrer</button>
    </form>

    <!-- Tableau des utilisateurs -->
    <table class="table-auto w-full">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2">Nom</th>
                <th class="p-2">Email</th>
                <th class="p-2">Rôle</th>
                <th class="p-2">Service</th>
                <th class="p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr class="border-b">
                <td class="p-2">{{ $user->name }}</td>
                <td class="p-2">{{ $user->email }}</td>
                <td class="p-2">{{ $user->role }}</td>
                <td class="p-2">{{ $user->service }}</td>
                <td class="p-2 space-x-2">
                    <button onclick="openEditModal('{{ $user->id }}', '{{ $user->name }}', '{{ $user->email }}', '{{ $user->role }}', '{{ $user->permission }}')" class="text-blue-500">
                        <i class="fas fa-pen fa-lg"></i></button>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Confirmer la suppression ?')" class="text-red-500">
                             <i class="fas fa-trash text-red-500 fa-lg"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal de modification -->
<!-- (Modal code remains unchanged) -->
<!-- Modal de modification -->
<div id="editModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-md w-96">
        <h2 class="text-xl font-bold mb-4">Modifier l'utilisateur</h2>
        <form method="POST" action="" id="editForm">
            @csrf
            @method('PUT')

            <input type="hidden" name="id" id="edit_id">

            <input type="text" name="name" id="edit_name" placeholder="Nom" class="border p-2 w-full mb-2" required>
            <input type="email" name="email" id="edit_email" placeholder="Email" class="border p-2 w-full mb-2" required>

            <input type="password" name="password" placeholder="Mot de passe" class="border p-2 w-full mb-2">
            <input type="password" name="password_confirmation" placeholder="Confirmer le mot de passe" class="border p-2 w-full mb-2">

            <select name="role" id="edit_role" class="border p-2 w-full mb-2" required>
                <option value="" disabled selected>Sélectionnez un rôle</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>

            <select name="service" id="edit_service" class="border p-2 w-full mb-2" required>
                <option value="" disabled selected>Sélectionnez un service</option>
                @foreach($services as $service)
                    <option value="{{ $service->id }}">{{ $service->nom }}</option>
                @endforeach
            </select>

            <input type="text" name="permission" id="edit_permission" placeholder="Permissions (optionnel)" class="border p-2 w-full mb-2">

            <div class="flex justify-end space-x-2 mt-4">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-400 text-white rounded">Annuler</button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(id, name, email, role, permission) {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_email').value = email;

        // Sélectionner le rôle dans le select
        document.getElementById('edit_role').value = role;

        // Remplir le champ de permission
        document.getElementById('edit_permission').value = permission;

        // Modifier l'action du formulaire
        document.getElementById('editForm').action = "{{ route('users.update', ':id') }}".replace(':id', id);

        // Afficher le modal
        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }
</script>
@endsection