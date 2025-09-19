<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

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
        $credentials = $request->only('email', 'password');

        // Vérifiez les identifiants
        $user = User::where('email', $credentials['email'])->where('role', 'coordinateur')->first();

        if ($user && password_verify($credentials['password'], $user->password)) {
            // Authentifier l'utilisateur et stocker son ID dans la session
            $request->session()->put('coordinator_id', $user->id);

            // Rediriger vers une page protégée ou dashboard
            return redirect()->route('coord-inter')->with('success', 'Connexion réussie !');
        }

        // Si les informations d'identification sont incorrectes
        return redirect()->back()->withErrors(['email' => 'Identifiants incorrects.']);
    }
}
