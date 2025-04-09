@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Dashboard') }}
                    </h2>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-1 gap-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-lg font-bold">{{ __("Archives") }}</h3>
                            <p>{{ __("Nombre total d'archives enregistrées :") }} <span class="font-semibold">{{ $archiveCount ?? 0 }}</span></p>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-lg font-bold">{{ __("Services") }}</h3>
                            <p>{{ __("Nombre total de services disponibles :") }} <span class="font-semibold">{{ $serviceCount ?? 0 }}</span></p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-lg font-bold">{{ __("Utilisateurs") }}</h3>
                            <p>{{ __("Nombre total d'utilisateurs enregistrés :") }} <span class="font-semibold">{{ $userCount ?? 0 }}</span></p>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-lg font-bold">{{ __("Types d'Archives") }}</h3>
                            <p>{{ __("Nombre total de types d'archives :") }} <span class="font-semibold">{{ $archiveTypeCount ?? 0 }}</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection