
@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- En-tête avec icône -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6 text-gray-900 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                    </svg>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Tableau de bord des archives') }}
                    </h2>
                </div>
            </div>

            <!-- Cartes statistiques avec icônes -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Carte Archives -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 flex items-start">
                        <div class="bg-indigo-100 p-3 rounded-full mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-700">{{ __("Archives") }}</h3>
                            <p class="text-gray-500 text-sm">{{ __("Total enregistrées") }}</p>
                            <p class="text-2xl font-semibold mt-1">{{ $archiveCount ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <!-- Carte Services -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 flex items-start">
                        <div class="bg-blue-100 p-3 rounded-full mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-700">{{ __("Services") }}</h3>
                            <p class="text-gray-500 text-sm">{{ __("Total disponibles") }}</p>
                            <p class="text-2xl font-semibold mt-1">{{ $serviceCount ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <!-- Carte Utilisateurs -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 flex items-start">
                        <div class="bg-green-100 p-3 rounded-full mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-700">{{ __("Utilisateurs") }}</h3>
                            <p class="text-gray-500 text-sm">{{ __("Total enregistrés") }}</p>
                            <p class="text-2xl font-semibold mt-1">{{ $userCount ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <!-- Carte Profils d'Archives -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 flex items-start">
                        <div class="bg-purple-100 p-3 rounded-full mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-700">{{ __("Profils d'Archives") }}</h3>
                            <p class="text-gray-500 text-sm">{{ __("Total disponibles") }}</p>
                            <p class="text-2xl font-semibold mt-1">{{ $archiveTypeCount ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Graphiques -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Graphique Évolution par service -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            <h3 class="text-lg font-bold">{{ __("Évolution des archives par service") }}</h3>
                        </div>
                        <div class="chart-container" style="height: 300px;">
                            <canvas id="serviceChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Graphique Répartition par type -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                            </svg>
                            <h3 class="text-lg font-bold">{{ __("Répartition des archives par type") }}</h3>
                        </div>
                        <div class="chart-container" style="height: 300px;">
                            <canvas id="typeChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Graphique Évolution par service (exemple avec données factices)
            const serviceCtx = document.getElementById('serviceChart').getContext('2d');
            const serviceChart = new Chart(serviceCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin'],
                    datasets: [
                        @foreach($servicesWithArchives as $service)
                        {
                            label: '{{ $service->nom }}',
                            data: @json($service->monthly_archives),
                            borderColor: getRandomColor(),
                            tension: 0.1,
                            fill: false
                        },
                        @endforeach
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Graphique Répartition par type (exemple avec données factices)
            const typeCtx = document.getElementById('typeChart').getContext('2d');
            const typeChart = new Chart(typeCtx, {
                type: 'pie',
                data: {
                    labels: [
                        @foreach($archiveTypes as $type)
                            '{{ $type->name }}',
                        @endforeach
                    ],
                    datasets: [{
                        data: [
                            @foreach($archiveTypes as $type)
                                {{ $type->archives_count }},
                            @endforeach
                        ],
                        backgroundColor: [
                            '#6366F1', '#EC4899', '#10B981', '#F59E0B', '#3B82F6'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });

            function getRandomColor() {
                const colors = ['#6366F1', '#EC4899', '#10B981', '#F59E0B', '#3B82F6'];
                return colors[Math.floor(Math.random() * colors.length)];
            }
        </script>
    @endsection
@endsection