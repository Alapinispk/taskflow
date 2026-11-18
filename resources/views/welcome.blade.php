<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'TaskFlow') }} - Gérez vos tâches efficacement</title>

    <!-- Polices -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts & Styles Vite (Tailwind CSS) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-slate-50 text-slate-800 selection:bg-indigo-500 selection:text-white">

    <!-- Barre de navigation -->
    <header class="bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <!-- Logo -->
            <a href="{{ url('/') }}" class="flex items-center gap-2 font-bold text-xl text-indigo-600">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>TaskFlow</span>
            </a>

            <!-- Liens d'authentification Laravel Breeze -->
            <nav class="flex items-center gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('tasks.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-indigo-700 transition">
                            Accéder à mes tâches
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition">
                            Se connecter
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-indigo-700 shadow-sm transition">
                                S'inscrire
                            </a>
                        @endif
                    @endauth
                @endif
            </nav>
        </div>
    </header>

    <!-- Section Héro -->
    <main>
        <section class="relative overflow-hidden pt-16 pb-20 lg:pt-24 lg:pb-28">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700 mb-6">
                    Simple • Rapide • Sécurisé
                </span>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-900 max-w-3xl mx-auto">
                    Organisez vos journées sans jamais rien oublier.
                </h1>

                <p class="mt-6 text-lg text-slate-600 max-w-2xl mx-auto leading-relaxed">
                    Centralisez vos tâches personnelles et professionnelles. Définissez vos priorités, suivez vos échéances et gardez le contrôle sur votre productivité au quotidien.
                </p>

                <!-- Boutons d'action principaux -->
                <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center">
                    @auth
                        <a href="{{ route('tasks.index') }}" class="px-8 py-3.5 rounded-xl bg-indigo-600 text-white font-semibold shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition">
                            Ouvrir mon espace de travail
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="px-8 py-3.5 rounded-xl bg-indigo-600 text-white font-semibold shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition">
                            Créer un compte
                        </a>
                        <a href="{{ route('login') }}" class="px-8 py-3.5 rounded-xl bg-white text-slate-700 font-semibold border border-slate-200 hover:bg-slate-50 transition">
                            J'ai déjà un compte
                        </a>
                    @endauth
                </div>

                <!-- Aperçu visuel (Maquette d'interface) -->
                <div class="mt-16 max-w-4xl mx-auto bg-white rounded-2xl shadow-xl border border-slate-200/80 overflow-hidden text-left">
                    <div class="bg-slate-100 px-4 py-3 border-b border-slate-200 flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-rose-400"></span>
                        <span class="w-3 h-3 rounded-full bg-amber-400"></span>
                        <span class="w-3 h-3 rounded-full bg-emerald-400"></span>
                        <span class="ml-2 text-xs text-slate-400 font-mono">Aperçu de votre tableau de bord</span>
                    </div>
                    <div class="p-6 space-y-4">
                        <!-- Exemple Tâche 1 -->
                        <div class="flex items-center justify-between p-4 rounded-xl border border-slate-100 bg-slate-50/50">
                            <div class="flex items-center gap-3">
                                <span class="w-5 h-5 rounded-md border-2 border-indigo-600 flex items-center justify-center"></span>
                                <div>
                                    <p class="font-semibold text-slate-800">Finaliser l'architecture Laravel</p>
                                    <p class="text-xs text-slate-500">Catégorie : Développement • Échéance : Aujourd'hui</p>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-rose-100 text-rose-700">Haute</span>
                        </div>
                        <!-- Exemple Tâche 2 -->
                        <div class="flex items-center justify-between p-4 rounded-xl border border-slate-100 bg-slate-50/50">
                            <div class="flex items-center gap-3">
                                <span class="w-5 h-5 rounded-md border-2 border-slate-300"></span>
                                <div>
                                    <p class="font-semibold text-slate-800">Préparer la réunion client</p>
                                    <p class="text-xs text-slate-500">Catégorie : Travail • Échéance : Demain</p>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-700">Moyenne</span>
                        </div>
                        <!-- Exemple Tâche 3 (Terminée) -->
                        <div class="flex items-center justify-between p-4 rounded-xl border border-slate-100 bg-slate-50/30 opacity-60">
                            <div class="flex items-center gap-3">
                                <span class="w-5 h-5 rounded-md bg-emerald-500 text-white flex items-center justify-center text-xs">✓</span>
                                <div>
                                    <p class="font-semibold text-slate-500 line-through">Installer Laravel Breeze</p>
                                    <p class="text-xs text-slate-400">Terminée</p>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-slate-200 text-slate-600">Basse</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section Fonctionnalités -->
        <section class="py-16 bg-white border-t border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Tout ce qu'il faut pour rester productif</h2>
                    <p class="mt-2 text-slate-600">Des outils pensés pour aller à l'essentiel, sans distraction.</p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Carte 1 -->
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100">
                        <div class="w-10 h-10 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-lg text-slate-900">Filtres & Recherche instantanée</h3>
                        <p class="mt-2 text-sm text-slate-600">Retrouvez n'importe quelle tâche par mot-clé ou filtrez par statut (à faire, terminées, en retard).</p>
                    </div>

                    <!-- Carte 2 -->
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100">
                        <div class="w-10 h-10 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-lg text-slate-900">Priorités & Catégories</h3>
                        <p class="mt-2 text-sm text-slate-600">Classez vos actions par niveau d'urgence (basse, moyenne, haute) et regroupez-les par projets.</p>
                    </div>

                    <!-- Carte 3 -->
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100">
                        <div class="w-10 h-10 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-lg text-slate-900">Espace privé et sécurisé</h3>
                        <p class="mt-2 text-sm text-slate-600">Vos données sont strictement isolées. Vous êtes le seul à voir et gérer vos propres listes.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Pied de page -->
    <footer class="bg-slate-50 border-t border-slate-200 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row justify-between items-center text-sm text-slate-500">
            <p>&copy; {{ date('Y') }} TaskFlow. Développé par SPK.</p>
            <div class="flex gap-4 mt-4 sm:mt-0">
                <a href="{{ route('login') }}" class="hover:text-slate-800">Connexion</a>
                <a href="{{ route('register') }}" class="hover:text-slate-800">Inscription</a>
            </div>
        </div>
    </footer>

</body>
</html>