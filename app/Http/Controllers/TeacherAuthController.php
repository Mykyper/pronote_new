<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Seance;

class TeacherAuthController extends Controller
{
    // Afficher le formulaire de connexion des enseignants
    public function showLoginForm()
    {
        return view('master_log');
    }

    // Traiter la connexion des enseignants
      public function apiLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Vérification des identifiants
        $user = User::where('email', $credentials['email'])
                    ->where('role', 'enseignant')
                    ->first();

        if ($user && password_verify($credentials['password'], $user->password)) {
            // (Option 1 : session API simple)
            // $request->session()->put('teacher_id', $user->id);

            // Réponse JSON
            return response()->json([
                'success' => true,
                'message' => 'Connexion réussie',
                'teacher' => [
                    'id' => $user->id,
                    'nom' => $user->nom,
                    'prenom' => $user->prenom,
                    'email' => $user->email,
                ]
            ], 200);
        }

        // Identifiants invalides
        return response()->json([
            'success' => false,
            'message' => 'Identifiants incorrects'
        ], 401);
    }

    /**
     * Récupérer l'emploi du temps d'un enseignant (API)
     */
    public function apiShow(Request $request)
    {
        // Vérifier si l'enseignant est en session API
        if (!$request->session()->has('teacher_id')) {
            return response()->json([
                'success' => false,
                'message' => 'Non authentifié'
            ], 401);
        }

        $teacherId = $request->session()->get('teacher_id');
        $teacher = User::find($teacherId);

        if (!$teacher) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur : enseignant introuvable'
            ], 404);
        }

        // Charger l'emploi du temps
        $emploiDuTemps = Seance::where('enseignant_id', $teacherId)
            ->orderBy('date', 'asc')
            ->get()
            ->groupBy(function($date) {
                return Carbon\Carbon::parse($date->date)->format('d/m/Y');
            });

        return response()->json([
            'success' => true,
            'teacher' => [
                'id' => $teacher->id,
                'nom' => $teacher->nom,
                'prenom' => $teacher->prenom,
                'email' => $teacher->email,
            ],
            'emploi_du_temps' => $emploiDuTemps
        ], 200);
    }
}
