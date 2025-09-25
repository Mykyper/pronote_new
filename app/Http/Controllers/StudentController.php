<?php

namespace App\Http\Controllers;

use App\Models\ParentModel; // Assurez-vous que ce modèle existe
use App\Models\Classe;
use App\Models\Eleve;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse; // ✅ Laravel JsonResponse

class StudentController extends Controller

  {
    public function index(): JsonResponse
{
    $eleves = Eleve::with(['classe:id,niveau,specialité', 'parent:id,nom,prenom,email'])
        ->get(['id', 'nom', 'prenom', 'email', 'classe_id', 'parent_id']);

    return response()->json([
        'success' => true,
        'eleves' => $eleves
    ]);
}
    public function showForm()
{
    $parents = ParentModel::all();
    $classes = Classe::all();
    return view('add_student', compact('parents', 'classes'));
}

    /**
     * Récupérer les données nécessaires pour créer un élève (API)
     */
    public function create(): JsonResponse
    {
        $parents = ParentModel::all(['id', 'nom', 'prenom', 'email']);
        $classes = Classe::all(['id', 'niveau', 'specialité']);

        return response()->json([
            'success' => true,
            'parents' => $parents,
            'classes' => $classes,
        ]);
    }

    /**
     * Ajouter un nouvel élève (API)
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:eleves,email',
            'password' => 'required|string|min:8',
            'parent_id' => 'required|exists:parents,id',
            'classe_id' => 'required|exists:classes,id',
        ]);

        $eleve = Eleve::create([
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'parent_id' => $validated['parent_id'],
            'classe_id' => $validated['classe_id'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Élève ajouté avec succès !',
            'eleve' => $eleve
        ], 201);
    }
}
