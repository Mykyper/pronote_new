<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse; 
use Illuminate\Support\Facades\Hash;
class CoordinatorAuthController extends Controller
{
    // Afficher le formulaire de connexion des coordinateurs
    public function showLoginForm()
    {
        return view('coord_log');
    }

    // Traiter la connexion des coordinateurs
   public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string|min:6',
    ]);

    $user = User::where('email', $request->email)
                ->where('role', 'coordinateur')
                ->first();

    if ($user && Hash::check($request->password, $user->password)) {
        session(['coordinator_id' => $user->id]);

        return response()->json([
            'success' => true,
            'message' => 'Connexion réussie !',
            'redirect' => route('coord-inter'),
             'user' => [
                'id' => $user->id,
                'nom' => $user->nom,
                'prenom' => $user->prenom,
                'email' => $user->email,
            ]
        ]);
    }

    return response()->json([
        'success' => false,
        'message' => 'Email ou mot de passe incorrect.'
    ], 401);
}
}
