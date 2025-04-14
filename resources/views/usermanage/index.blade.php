@extends('layouts.app')


@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold mb-4">Liste des utilisateurs</h2>

    <!-- Filtres -->
    <form method="GET" action="{{ route('users.index') }}" class="mb-6 flex space-x-4">
        <select name="service" class="border p-2">
            <option value="">Tous les services</option>
            @foreach($services as $service)
                <option value="{{ $service->id }}" {{ request('service') == $service->id ? 'selected' : '' }}>
                    {{ $service->nom }}
                </option>
            @endforeach
        </select>

        <select name="role" class="border p-2">
            <option value="">Tous les rôles</option>
            @foreach($roles as $role)
                <option value="{{ $role }}" {{ request('role') == $role ? 'selected' : '' }}>
                    {{ ucfirst($role) }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Filtrer</button>
    </form>

    <!-- Tableau utilisateurs -->
    <table class="min-w-full bg-white border">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="py-2 px-4 border-b">Nom</th>
                <th class="py-2 px-4 border-b">Email</th>
                <th class="py-2 px-4 border-b">Rôle</th>
                <th class="py-2 px-4 border-b">Service</th>
                <th class="py-2 px-4 border-b text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td class="py-2 px-4 border-b">{{ $user->name }}</td>
                <td class="py-2 px-4 border-b">{{ $user->email }}</td>
                <td class="py-2 px-4 border-b">{{ $user->role }}</td>
                <td class="py-2 px-4 border-b">{{ $user->service->nom ?? 'N/A' }}</td>
                <td class="py-2 px-4 border-b text-center">
                    <a href="{{ route('users.edit', $user->id) }}" class="text-blue-500 hover:underline mr-2">Modifier</a>

                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Confirmer la suppression ?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-500 hover:underline">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    
</div>
@endsection
