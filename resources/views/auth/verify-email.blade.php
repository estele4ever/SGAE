<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Merci d'etre enregistrer! Avant de commencer, pouvez vous verifire votre adresse email en clickant sur le lien que nous vous avons envoyer?Si vous n'avez pas recu le message , nous auron le plaisir de vous envoyer un autre.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('Un nouveau lien a ete envoyer a l'adresse email que vous produirez pendant l'enregistrement.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('Renvoyer l'email de verification') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Deconnecter') }}
            </button>
        </form>
    </div>
</x-guest-layout>
