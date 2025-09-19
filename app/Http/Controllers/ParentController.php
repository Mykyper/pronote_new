<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\ParentModel; // Import the Parent model
use Illuminate\Http\JsonResponse;

class ParentController extends Controller
{
    
    public function create()
    {
        return view('add_parent'); 
    }

    
        public function store(Request $request): JsonResponse
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:parents,email',
            'password' => 'required|string|min:6',
        ]);

        $parent = ParentModel::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Parent ajouté avec succès !',
            'parent' => $parent
        ], 201);
    }

    /**
     * Lister tous les parents (API)
     */
    public function index(): JsonResponse
    {
        $parents = ParentModel::all();

        return response()->json([
            'success' => true,
            'parents' => $parents
        ], 200);
    }

    /**
     * Déconnexion parent (API)
     */
    public function logout(Request $request): JsonResponse
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'success' => true,
            'message' => 'Vous vous êtes déconnecté avec succès.'
        ], 200);
    }
}

