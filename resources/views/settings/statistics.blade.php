@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-bold mb-4">Statistiques</h2>
    <p>Nombre total d'archives : {{ $totalArchives }}</p>
    <p>Nombre d’utilisateurs actifs : {{ $activeUsers }}</p>
</div>
@endsection
