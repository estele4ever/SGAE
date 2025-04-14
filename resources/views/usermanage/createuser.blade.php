
@extends('layouts.app')
@section('title', 'Créer un utilisateur')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Créer un nouvel utilisateur</h2>
    <form method="POST" action="{{ route('users.store') }}">
        @csrf
        <input type="text" name="name" placeholder="Nom" class="w-full p-2 border mb-3" required>
        <input type="email" name="email" placeholder="Email" class="w-full p-2 border mb-3" required>
        <input type="password" name="password" placeholder="Mot de passe" class="w-full p-2 border mb-3" required>
        <select name="role" class="w-full p-2 border mb-3">
            <option value="">Sélectionner un rôle</option>
            @foreach($roles as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
            @endforeach
        </select>
        <select name="permission" class="w-full p-2 border mb-3">
            <option value="">Sélectionner une permission</option>
            @foreach($permissions as $permission)
                <option value="{{ $permission->id }}">{{ $permission->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Enregistrer</button>
    </form>
</div>
@endsection