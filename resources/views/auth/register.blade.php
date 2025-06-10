<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-50">
        <div class="w-full sm:max-w-md px-6 py-8 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <!-- Logo et Titre -->
            <div class="text-center">
                <div class="flex justify-center">
                    <x-application-se class="w-20 h-20 fill-current text-indigo-600" />
                </div>
                <h2 class="mt-4 text-3xl font-extrabold text-gray-900">Créer un compte</h2>
                <p class="mt-2 text-sm text-gray-600">Rejoignez notre communauté</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-6">
                @csrf

                <!-- Nom -->
                <div>
                    <x-input-label for="name" :value="__('Nom complet')" />
                    <x-text-input 
                        id="name" 
                        class="block mt-1 w-full" 
                        type="text" 
                        name="name" 
                        :value="old('name')" 
                        required 
                        autofocus 
                        autocomplete="name"
                        placeholder="Votre nom complet"
                    />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Adresse email')" />
                    <x-text-input 
                        id="email" 
                        class="block mt-1 w-full" 
                        type="email" 
                        name="email" 
                        :value="old('email')" 
                        required 
                        autocomplete="email"
                        placeholder="votre@email.com"
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Mot de passe -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Mot de passe')" />
                    <div class="relative">
                        <x-text-input 
                            id="password" 
                            class="block w-full pr-10" 
                            type="password" 
                            name="password" 
                            required 
                            autocomplete="new-password"
                            placeholder="••••••••"
                            onkeyup="validatePassword()"
                        />
                        <button type="button" onclick="togglePasswordVisibility('password')" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    
                    <div id="passwordHelp" class="mt-2 text-sm text-gray-600 space-y-1 hidden">
                        <p class="flex items-center" id="lengthCheck">
                            <span id="lengthIcon" class="mr-2">🔹</span>
                            Au moins 8 caractères
                        </p>
                        <p class="flex items-center" id="complexityCheck">
                            <span id="complexityIcon" class="mr-2">🔹</span>
                            Lettres et chiffres
                        </p>
                    </div>
                    
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirmation mot de passe -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />
                    <div class="relative">
                        <x-text-input 
                            id="password_confirmation" 
                            class="block w-full pr-10" 
                            type="password" 
                            name="password_confirmation" 
                            required 
                            autocomplete="new-password"
                            placeholder="••••••••"
                            onkeyup="validatePasswordConfirmation()"
                        />
                        <button type="button" onclick="togglePasswordVisibility('password_confirmation')" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    <div id="passwordMatch" class="mt-2 text-sm text-gray-600 hidden">
                        <p class="flex items-center">
                            <span id="matchIcon" class="mr-2">🔹</span>
                            <span id="matchText">Les mots de passe correspondent</span>
                        </p>
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Bouton d'inscription -->
                <div class="mt-6">
                    <x-primary-button id="submitButton" class="w-full justify-center py-3" disabled>
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        {{ __('S\'inscrire') }}
                    </x-primary-button>
                </div>

                <!-- Lien vers connexion -->
                <div class="text-center text-sm text-gray-600 mt-4">
                    <p>Déjà inscrit ? 
                        <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                            Se connecter
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePasswordVisibility(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        }

        function validatePassword() {
            const password = document.getElementById('password').value;
            const helpDiv = document.getElementById('passwordHelp');
            const lengthCheck = document.getElementById('lengthCheck');
            const complexityCheck = document.getElementById('complexityCheck');
            const lengthIcon = document.getElementById('lengthIcon');
            const complexityIcon = document.getElementById('complexityIcon');
            const submitButton = document.getElementById('submitButton');

            // Afficher les conseils
            helpDiv.classList.remove('hidden');

            // Validation longueur
            if (password.length >= 8) {
                lengthIcon.textContent = '✅';
                lengthCheck.classList.remove('text-gray-600');
                lengthCheck.classList.add('text-green-600');
            } else {
                lengthIcon.textContent = '❌';
                lengthCheck.classList.remove('text-green-600');
                lengthCheck.classList.add('text-red-500');
            }

            // Validation complexité
            if (/[a-zA-Z]/.test(password) && /[0-9]/.test(password)) {
                complexityIcon.textContent = '✅';
                complexityCheck.classList.remove('text-gray-600');
                complexityCheck.classList.add('text-green-600');
            } else {
                complexityIcon.textContent = '❌';
                complexityCheck.classList.remove('text-green-600');
                complexityCheck.classList.add('text-red-500');
            }

            // Activer le bouton si toutes les conditions sont remplies
            validateForm();
        }

        function validatePasswordConfirmation() {
            const password = document.getElementById('password').value;
            const confirmation = document.getElementById('password_confirmation').value;
            const matchDiv = document.getElementById('passwordMatch');
            const matchIcon = document.getElementById('matchIcon');
            const matchText = document.getElementById('matchText');

            if (password && confirmation) {
                matchDiv.classList.remove('hidden');
                
                if (password === confirmation) {
                    matchIcon.textContent = '✅';
                    matchText.textContent = 'Les mots de passe correspondent';
                    matchDiv.classList.remove('text-gray-600');
                    matchDiv.classList.add('text-green-600');
                } else {
                    matchIcon.textContent = '❌';
                    matchText.textContent = 'Les mots de passe ne correspondent pas';
                    matchDiv.classList.remove('text-green-600');
                    matchDiv.classList.add('text-red-500');
                }
            } else {
                matchDiv.classList.add('hidden');
            }

            validateForm();
        }

        function validateForm() {
            const password = document.getElementById('password').value;
            const confirmation = document.getElementById('password_confirmation').value;
            const submitButton = document.getElementById('submitButton');

            // Vérifier toutes les conditions
            const isLengthValid = password.length >= 8;
            const isComplexValid = /[a-zA-Z]/.test(password) && /[0-9]/.test(password);
            const isMatchValid = password === confirmation && password !== '';

            if (isLengthValid && isComplexValid && isMatchValid) {
                submitButton.disabled = false;
            } else {
                submitButton.disabled = true;
            }
        }
    </script>
</x-guest-layout>