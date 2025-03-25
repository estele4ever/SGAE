<x-guest-layout>
    <!-- Session Status -->
      
            <h2 class="text-2xl font-bold text-gray-700 ">Connexion</h2>
     

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Formulaire de connexion -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Mot de passe avec bouton afficher/masquer -->
            <div class="mt-4 relative">
                <x-input-label for="password" :value="__('Mot de passe')" />
                <x-text-input id="password" class="block mt-1 w-full pr-10" type="password" name="password" required autocomplete="current-password" />
                
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Se souvenir de moi -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Se souvenir de moi') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-between mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Mot de passe oublié ?') }}
                    </a>
                @endif

                <x-primary-button>
                    {{ __('Se connecter') }}
                </x-primary-button>
            </div>

            <!-- Bouton Register -->
            <div class="mt-4 text-center">
                <p class="text-sm text-gray-600">Pas encore enregistré ?</p>
                <a href="{{ route('register') }}" class="text-blue-500 hover:text-blue-700 font-semibold">
                    S'enregistrer
                </a>
            </div>
        </form>
    

</x-guest-layout>
