<x-app-layout>
    <div class="py-8" x-data="todoApp()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- En-tête avec Titre et Bouton PLUS -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 border border-slate-200">
                <div>
                    <h2 class="font-bold text-2xl text-slate-900 flex items-center gap-2">
                        <span>Mes Tâches & Projets</span>
                    </h2>
                    <p class="text-sm text-slate-500 mt-1">Gérez vos priorités en temps réel.</p>
                </div>
                
                <div class="flex items-center gap-3">
                    <!-- Bouton PLUS pour ouvrir la modale d'ajout -->
                    <button @click="showModal = true" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2.5 rounded-none flex items-center gap-2 transition text-sm shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        <span>Nouvelle Tâche</span>
                    </button>
                    <!-- Bouton Gestion Catégorie -->
                    <button @click="showCategoryModal = true" class="bg-slate-900 hover:bg-slate-800 text-white font-semibold px-4 py-2.5 rounded-none transition text-sm">
                        + Catégorie
                    </button>
                </div>
            </div>

            <!-- Barre de recherche et filtres dynamiques -->
            <div class="bg-white border border-slate-200 p-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 items-center">
                    <div class="lg:col-span-4">
                        <input type="text" x-model="search" @input.debounce.300ms="fetchTasks()" placeholder="Rechercher..." class="w-full border-slate-300 rounded-none text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div class="lg:col-span-3">
                        <select x-model="filtre" @change="fetchTasks()" class="w-full border-slate-300 rounded-none text-sm">
                            <option value="">Tous les statuts</option>
                            <option value="a_faire">À faire</option>
                            <option value="terminee">Terminées</option>
                            <option value="en_retard">En retard</option>
                        </select>
                    </div>
                    <div class="lg:col-span-2">
                        <select x-model="priorite" @change="fetchTasks()" class="w-full border-slate-300 rounded-none text-sm">
                            <option value="">Toutes priorités</option>
                            <option value="basse">Basse</option>
                            <option value="moyenne">Moyenne</option>
                            <option value="haute">Haute</option>
                        </select>
                    </div>
                    <div class="lg:col-span-2">
                        <select x-model="categoryId" @change="fetchTasks()" class="w-full border-slate-300 rounded-none text-sm">
                            <option value="">Toutes catégories</option>
                            <template x-for="cat in categories" :key="cat.id">
                                <option :value="cat.id" x-text="cat.nom"></option>
                            </template>
                        </select>
                    </div>
                    <div class="lg:col-span-1">
                        <button @click="resetFilters()" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 py-2.5 text-sm rounded-none transition text-center font-medium">
                            Reset
                        </button>
                    </div>
                </div>
            </div>

            <!-- Liste des tâches (Mise à jour AJAX) -->
            <div class="bg-white border border-slate-200">
                <div class="p-4 border-b border-slate-100 font-bold text-slate-800 text-sm uppercase tracking-wider">
                    Liste des tâches (<span x-text="tasks.length"></span>)
                </div>

                <div class="divide-y divide-slate-100">
                    <template x-for="task in tasks" :key="task.id">
                        <div class="p-4 flex items-center justify-between gap-4 hover:bg-slate-50 transition">
                            <div class="flex items-start gap-3">
                                <!-- Checkbox / Bouton Terminer -->
                                <button @click="toggleStatus(task)" class="mt-1 text-slate-400 hover:text-indigo-600 focus:outline-none">
                                    <template x-if="task.statut === 'terminee'">
                                        <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                    </template>
                                    <template x-if="task.statut !== 'terminee'">
                                        <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/></svg>
                                    </template>
                                </button>

                                <div>
                                    <h4 class="font-bold text-slate-800 text-base" :class="task.statut === 'terminee' ? 'line-through text-slate-400' : ''" x-text="task.titre"></h4>
                                    <p class="text-sm text-slate-600 mt-0.5" x-text="task.description"></p>
                                    
                                    <div class="flex flex-wrap items-center gap-2 mt-2 text-xs">
                                        <span class="px-2 py-0.5 font-semibold uppercase border"
                                            :class="{
                                                'bg-slate-100 text-slate-700 border-slate-200': task.priorite === 'basse',
                                                'bg-amber-50 text-amber-700 border-amber-200': task.priorite === 'moyenne',
                                                'bg-rose-50 text-rose-700 border-rose-200': task.priorite === 'haute'
                                            }" x-text="task.priorite"></span>

                                        <template x-if="task.category">
                                            <span class="bg-indigo-50 text-indigo-700 px-2 py-0.5 border border-indigo-200 font-medium" x-text="task.category.nom"></span>
                                        </template>

                                        <template x-if="task.echeance">
                                            <span class="text-slate-500 font-medium" x-text="'Échéance : ' + task.echeance"></span>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div>
                                <button @click="deleteTask(task.id)" class="text-slate-400 hover:text-rose-600 p-2 rounded-none transition" title="Supprimer">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </div>
                    </template>

                    <!-- Message vide -->
                    <template x-if="tasks.length === 0">
                        <div class="p-12 text-center text-slate-500">
                            <p class="font-medium">Aucune tâche trouvée.</p>
                        </div>
                    </template>
                </div>
            </div>

        </div>

        <!-- MODALE CRÉATION DE TÂCHE (Bouton PLUS) -->
        <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm" style="display: none;">
            <div @click.away="showModal = false" class="bg-white w-full max-w-lg p-6 border border-slate-200 shadow-xl">
                <div class="flex justify-between items-center mb-4 border-b pb-3">
                    <h3 class="font-bold text-lg text-slate-900">Créer une nouvelle tâche</h3>
                    <button @click="showModal = false" class="text-slate-400 hover:text-slate-600">&times;</button>
                </div>

                <form @submit.prevent="createTask()" class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-700 mb-1">Titre *</label>
                        <input type="text" x-model="form.titre" required class="w-full border-slate-300 rounded-none text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-700 mb-1">Description</label>
                        <textarea x-model="form.description" rows="2" class="w-full border-slate-300 rounded-none text-sm"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold uppercase text-slate-700 mb-1">Priorité</label>
                            <select x-model="form.priorite" class="w-full border-slate-300 rounded-none text-sm">
                                <option value="basse">Basse</option>
                                <option value="moyenne" selected>Moyenne</option>
                                <option value="haute">Haute</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase text-slate-700 mb-1">Catégorie</label>
                            <select x-model="form.category_id" class="w-full border-slate-300 rounded-none text-sm">
                                <option value="">Aucune</option>
                                <template x-for="cat in categories" :key="cat.id">
                                    <option :value="cat.id" x-text="cat.nom"></option>
                                </template>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-700 mb-1">Échéance</label>
                        <input type="date" x-model="form.echeance" class="w-full border-slate-300 rounded-none text-sm">
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" @click="showModal = false" class="px-4 py-2 bg-slate-200 text-slate-700 font-semibold text-sm rounded-none">Annuler</button>
                        <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm rounded-none">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- MODALE CRÉATION DE CATÉGORIE -->
        <div x-show="showCategoryModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm" style="display: none;">
            <div @click.away="showCategoryModal = false" class="bg-white w-full max-w-md p-6 border border-slate-200 shadow-xl">
                <div class="flex justify-between items-center mb-4 border-b pb-3">
                    <h3 class="font-bold text-lg text-slate-900">Ajouter une catégorie</h3>
                    <button @click="showCategoryModal = false" class="text-slate-400 hover:text-slate-600">&times;</button>
                </div>

                <form @submit.prevent="createCategory()" class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-700 mb-1">Nom de la catégorie *</label>
                        <input type="text" x-model="categoryForm.nom" required class="w-full border-slate-300 rounded-none text-sm">
                    </div>
                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" @click="showCategoryModal = false" class="px-4 py-2 bg-slate-200 text-slate-700 font-semibold text-sm rounded-none">Annuler</button>
                        <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm rounded-none">Créer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script Alpine.js pour la logique AJAX -->
    <script>
        function todoApp() {
            return {
                tasks: @json($tasks),
                categories: @json($categories),
                search: '',
                filtre: '',
                priorite: '',
                categoryId: '',
                showModal: false,
                showCategoryModal: false,
                form: { titre: '', description: '', priorite: 'moyenne', category_id: '', echeance: '' },
                categoryForm: { nom: '' },

                fetchTasks() {
                    let params = new URLSearchParams({
                        search: this.search,
                        filtre: this.filtre,
                        priorite: this.priorite,
                        category_id: this.categoryId
                    });

                    fetch(`{{ route('tasks.index') }}?` + params.toString(), {
                        headers: { 'Accept': 'application/json' }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.tasks = data.tasks;
                    });
                },

                createTask() {
                    fetch(`{{ route('tasks.store') }}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(this.form)
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.tasks.unshift(data.task);
                        this.showModal = false;
                        this.form = { titre: '', description: '', priorite: 'moyenne', category_id: '', echeance: '' };
                    });
                },

                toggleStatus(task) {
                    let newStatus = task.statut === 'terminee' ? 'a_faire' : 'terminee';
                    fetch(`/tasks/${task.id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ statut: newStatus })
                    })
                    .then(res => res.json())
                    .then(data => {
                        task.statut = data.task.statut;
                    });
                },

                deleteTask(id) {
                    if (!confirm('Voulez-vous vraiment supprimer cette tâche ?')) return;

                    fetch(`/tasks/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(() => {
                        this.tasks = this.tasks.filter(t => t.id !== id);
                    });
                },

                createCategory() {
                    fetch(`{{ route('categories.store') }}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(this.categoryForm)
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.categories.push(data.category);
                        this.showCategoryModal = false;
                        this.categoryForm.nom = '';
                    });
                },

                resetFilters() {
                    this.search = '';
                    this.filtre = '';
                    this.priorite = '';
                    this.categoryId = '';
                    this.fetchTasks();
                }
            }
        }
    </script>
</x-app-layout>