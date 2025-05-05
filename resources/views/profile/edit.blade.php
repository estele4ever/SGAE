@extends('layouts.app')

@section('content')
    
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    {{ __('Profile') }}
    <img src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim($user->email))) }}" alt="Image de profil" class="rounded-full h-12 w-12" />
</h2>
   

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
 
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
    @endsection