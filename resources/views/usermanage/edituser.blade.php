//affiche la liste des users,fait la recherche en fonction du role ou du servic
//propose de modifier et supprimer
@extends('layouts.app')


@section('content')
<div class="container mx-auto">
    <h2 class="text-xl font-bold mb-4">Lise des utilisateurs</h2>
    
    <form method="GET" action="{{ route('users.index') }}" class="mb-4 flex space-x-2">
    <select name="service_id" id="service_id" class="form-select">
    @foreach ($services as $service)
        <option value="{{ $service->id }}" {{ $users->service_id == $service->id ? 'selected' : '' }}>
            {{ $service->nom }}
        </option>
    @endforeach
</select>

        <select name="role" class="border p-2">
            <option value="">Tous les rôles</option>
            @foreach($roles as $role)
                <option value="{{ $role->id }}" {{ request('role') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-gray-500 text-white px-4">Filtrer</button>
    </form>

    <table class="table-auto w-full">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2">Nom</th>
                <th class="p-2">Email</th>
                <th class="p-2">Rôle</th>
                <th class="p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr class="border-b">
                <td class="p-2">{{ $user->name }}</td>
                <td class="p-2">{{ $user->email }}</td>
                <td class="p-2">{{ $user->role->name ?? 'N/A' }}</td>
                <td class="p-2 space-x-2">
                    <a href="{{ route('users.edit', $user->id) }}" class="text-blue-500">Modifier</a>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Confirmer la suppression ?')" class="text-red-500">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
