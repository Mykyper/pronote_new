<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Eleve;
use App\Models\Seance;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
class StudentAuthController extends Controller
{
    // Afficher le formulaire de connexion
    public function showLoginForm()
    {
        return view('eleve_log');
    }

    // Traiter la connexion
     public function login(Request $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        // Vérifiez les identifiants
        $eleve = Eleve::where('email', $credentials['email'])->first();

        if ($eleve && password_verify($credentials['password'], $eleve->password)) {
            // Authentifier l'utilisateur et stocker son ID dans la session ou token
            

            return response()->json([
                'success' => true,
                'message' => 'Connexion réussie',
                'student' => [
                    'id' => $eleve->id,
                    'nom' => $eleve->nom,
                    'prenom' => $eleve->prenom,
                    'classe_id' => $eleve->classe_id
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Identifiants incorrects'
        ], 401);
    }

    /**
     * Récupérer l'emploi du temps de l'élève (API)
     */
    public function show(Request $request): JsonResponse
    {
        $studentId = $request->session()->get('student_id');

        if (!$studentId) {
            return response()->json([
                'success' => false,
                'message' => 'Vous devez être connecté pour accéder à cette ressource.'
            ], 401);
        }

        $eleve = Eleve::find($studentId);
        if (!$eleve || !$eleve->classe_id) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de connexion ou élève introuvable.'
            ], 400);
        }

        $classId = $eleve->classe_id;

        // Récupérer les 10 dates les plus récentes pour la classe
        $recentDates = Seance::where('class_id', $classId)
            ->orderBy('date', 'asc')
            ->take(10)
            ->pluck('date')
            ->unique()
            ->toArray();

        $emploiDuTemps = [];

        foreach ($recentDates as $date) {
            $seancesMatin = Seance::where('class_id', $classId)
                ->whereDate('date', $date)
                ->where('periode', 'matin')
                ->orderBy('created_at', 'desc')
                ->get();

            $seancesSoir = Seance::where('class_id', $classId)
                ->whereDate('date', $date)
                ->where('periode', 'soir')
                ->orderBy('created_at', 'desc')
                ->get();

            $emploiDuTemps[$date] = [
                'matin' => $seancesMatin,
                'soir' => $seancesSoir
            ];
        }

        return response()->json([
            'success' => true,
            'student' => [
                'id' => $eleve->id,
                'nom' => $eleve->nom,
                'prenom' => $eleve->prenom,
                'classe_id' => $classId
            ],
            'emploiDuTemps' => $emploiDuTemps
        ]);
    }
}
