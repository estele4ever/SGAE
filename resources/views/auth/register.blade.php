<x-guest-layout>
<form method="POST" action="{{ route('register') }}">
    @csrf

    <!-- Titre -->
    <h2 class="text-2xl font-bold text-center mb-4">Créer un compte</h2>

    <!-- Name -->
    <div>
        <x-input-label for="name" :value="__('Nom')" />
        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <!-- Email -->
    <div class="mt-4">
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <!-- Password -->
    <div class="mt-4">
        <x-input-label for="password" :value="__('Mot de passe')" />
        
        <div class="relative">
            <x-text-input id="password" class="block mt-1 w-full pr-10" type="password" name="password" required autocomplete="new-password" onkeyup="validatePassword()" />
            
        </div>

        <!-- Message de validation -->
        <p id="passwordHelp" class="text-sm text-gray-500 mt-1 hidden">
            🔹 Doit contenir au moins 8 caractères.
        </p>

        <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <!-- Confirm Password -->
    <div class="mt-4">
        <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />
        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
    </div>

    <!-- Boutons -->
    <div class="flex items-center justify-between mt-4">
        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
            {{ __('Déjà inscrit ?') }}
        </a>
        <x-primary-button>
            {{ __('S\'inscrire') }}
        </x-primary-button>
    </div>
</form>

<!-- JavaScript -->
<script>
   

    function validatePassword() {
        let passwordField = document.getElementById('password');
        let passwordHelp = document.getElementById('passwordHelp');

        if (passwordField.value.length < 8) {
            passwordHelp.classList.remove('hidden');
            passwordHelp.classList.add('text-red-500');
        } else {
            passwordHelp.classList.add('hidden');
        }
    }
</script>

</x-guest-layout>
