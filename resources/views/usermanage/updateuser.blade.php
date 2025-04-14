//page pour modifier les informations du user
@extends('layout')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Modifier l'utilisateur</h2>
    <form method="POST" action="{{ route('users.update', $user->id) }}">
        @csrf
        @method('PUT')
        <input type="text" name="name" value="{{ $user->name }}" class="w-full p-2 border mb-3" required>
        <input type="email" name="email" value="{{ $user->email }}" class="w-full p-2 border mb-3" required>
        <select name="role" class="w-full p-2 border mb-3">
            @foreach($roles as $role)
                <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
            @endforeach
        </select>
        <select name="permission" class="w-full p-2 border mb-3">
            @foreach($permissions as $permission)
                <option value="{{ $permission->id }}" {{ $user->permission_id == $permission->id ? 'selected' : '' }}>{{ $permission->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Mettre à jour</button>
    </form>
</div>
@endsection