<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        // Uniquement les tâches de l'utilisateur connecté
        $query = $request->user()->tasks()->with('category');

        // Filtre par statut ou retard
        if ($request->filled('filtre')) {
            match ($request->filtre) {
                'a_faire' => $query->where('statut', 'a_faire'),
                'terminee' => $query->where('statut', 'terminee'),
                'en_retard' => $query->where('statut', 'a_faire')
                                     ->whereDate('echeance', '<', now()->toDateString()),
                default => null,
            };
        }

        // Filtre par priorité ou catégorie
        if ($request->filled('priorite')) {
            $query->where('priorite', $request->priorite);
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Recherche par mot-clé
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('titre', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        return response()->json($query->latest()->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priorite' => 'in:basse,moyenne,haute',
            'echeance' => 'nullable|date',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        // Vérifier que la catégorie appartient bien à l'utilisateur
        if (!empty($validated['category_id'])) {
            $request->user()->categories()->findOrFail($validated['category_id']);
        }

        $task = $request->user()->tasks()->create($validated);

        return response()->json($task, 201);
    }

    public function update(Request $request, Task $task)
    {
        Gate::authorize('update', $task); // Bloque si user_id !== auth()->id()

        $validated = $request->validate([
            'titre' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'statut' => 'sometimes|in:a_faire,terminee',
            'priorite' => 'sometimes|in:basse,moyenne,haute',
            'echeance' => 'nullable|date',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $task->update($validated);

        return response()->json($task);
    }

    public function destroy(Task $task)
    {
        Gate::authorize('delete', $task);
        $task->delete();

        return response()->json(['message' => 'Tâche supprimée']);
    }
}