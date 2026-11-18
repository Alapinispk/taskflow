<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = $user->tasks()->with('category');

        if ($request->filled('filtre')) {
            match ($request->filtre) {
                'a_faire' => $query->where('statut', 'a_faire'),
                'terminee' => $query->where('statut', 'terminee'),
                'en_retard' => $query->where('statut', 'a_faire')
                                     ->whereDate('echeance', '<', now()->toDateString()),
                default => null,
            };
        }

        if ($request->filled('priorite')) {
            $query->where('priorite', $request->priorite);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('titre', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $tasks = $query->latest()->get();
        $categories = $user->categories;

        // Si la requête attend du JSON (AJAX)
        if ($request->wantsJson()) {
            return response()->json([
                'tasks' => $tasks,
                'categories' => $categories
            ]);
        }

        return view('tasks.index', compact('tasks', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priorite' => 'required|in:basse,moyenne,haute',
            'echeance' => 'nullable|date',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        if (!empty($validated['category_id'])) {
            Auth::user()->categories()->findOrFail($validated['category_id']);
        }

        $task = Auth::user()->tasks()->create($validated);
        $task->load('category');

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Tâche créée avec succès', 'task' => $task], 201);
        }

        return redirect()->route('tasks.index');
    }

    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'titre' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'statut' => 'sometimes|in:a_faire,terminee',
            'priorite' => 'sometimes|in:basse,moyenne,haute',
            'echeance' => 'nullable|date',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $task->update($validated);
        $task->load('category');

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Tâche mise à jour', 'task' => $task]);
        }

        return redirect()->route('tasks.index');
    }

    public function destroy(Request $request, Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }

        $task->delete();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Tâche supprimée']);
        }

        return redirect()->route('tasks.index');
    }

    // Gestion des catégories
    public function storeCategory(Request $request)
    {
        $validated = $request->validate(['nom' => 'required|string|max:255']);
        $category = Auth::user()->categories()->create($validated);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Catégorie créée', 'category' => $category], 201);
        }

        return back();
    }
}