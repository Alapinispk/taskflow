
<x-guest-layout>
    <!-- En-tête de la carte d'inscription -->
    <div class="mb-6 text-center">
        <a href="{{ url('/') }}" class="inline-flex items-center gap-2 font-bold text-xl text-indigo-600 mb-2">
            <div class="p-1.5 bg-indigo-600 text-white rounded-lg">
                <i data-lucide="check-square" class="w-5 h-5"></i>
            </div>
            <span>TaskFlow</span>
        </a>
        <h2 class="text-xl font-bold text-slate-900">Créez votre compte</h2>
        <p class="text-sm text-slate-600 mt-1">Commencez à organiser vos tâches dès aujourd'hui.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Nom -->
        <div>
            <x-input-label for="name" :value="__('Nom complet')" class="text-slate-700 font-medium" />
            <x-text-input id="name" class="block mt-1 w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Ex: Remy ADAN" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Adresse Email -->
        <div>
            <x-input-label for="email" :value="__('Adresse email')" class="text-slate-700 font-medium" />
            <x-text-input id="email" class="block mt-1 w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="votre@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Mot de passe -->
        <div>
            <x-input-label for="password" :value="__('Mot de passe')" class="text-slate-700 font-medium" />
            <x-text-input id="password" class="block mt-1 w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                            type="password"
                            name="password"
                            required autocomplete="new-password" 
                            placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirmation du mot de passe -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" class="text-slate-700 font-medium" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" 
                            placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between pt-2">
            <a class="text-sm text-slate-600 hover:text-indigo-600 transition underline font-medium" href="{{ route('login') }}">
                {{ __('Déjà inscrit ?') }}
            </a>

            <x-primary-button class="ml-4 inline-flex items-center justify-center px-5 py-2.5 bg-indigo-600 border border-transparent rounded-xl font-semibold text-sm text-white hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-md shadow-indigo-100">
                {{ __('S\'inscrire') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
