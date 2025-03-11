@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-bold mb-4">Gestion du stockage</h2>
    <p>Espace utilisé : {{ $usedSpace }} / {{ $totalSpace }} Go</p>

    <progress value="{{ $usedSpace }}" max="{{ $totalSpace }}" class="w-full"></progress>

    <form method="POST" action="{{ route('settings.clearStorage') }}" class="mt-4">
        @csrf
        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Nettoyer les archives obsolètes</button>
    </form>
</div>
@endsection
