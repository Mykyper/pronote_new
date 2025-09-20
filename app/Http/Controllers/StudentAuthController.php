<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Eleve;
use App\Models\Seance;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

class StudentAuthController extends Controller
{
    // Formulaire de connexion
    public function showLoginForm()
    {
        return view('eleve_log');
    }

    // Login
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        $eleve = Eleve::where('email', $credentials['email'])->first();

        if ($eleve && Hash::check($credentials['password'], $eleve->password)) {
            // Stocker l'id élève dans la session
            $request->session()->put('student_id', $eleve->id);

            return response()->json([
                'success' => true,
                'message' => 'Connexion réussie',
                'redirect' => route('student-inter'),
                'student' => [
                    'id' => $eleve->id,
                    'nom' => $eleve->nom,
                    'prenom' => $eleve->prenom,
                    'classe_id' => $eleve->classe_id
                ]
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Identifiants incorrects'
        ], 401);
    }

    // Interface élève
    public function interface(Request $request)
    {
        // Vérifier que l'élève est connecté
        if (!$request->session()->has('student_id')) {
            return redirect()->route('student.login.form');
        }

        return view('eleve_interface');
    }

    // Récupérer l'emploi du temps (API)
    public function showEmploi(Request $request): JsonResponse
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

        $recentDates = Seance::where('class_id', $classId)
            ->orderBy('date', 'desc')
            ->pluck('date')
            ->unique()
            ->take(10)
            ->toArray();

        $seances = Seance::where('class_id', $classId)
            ->whereIn('date', $recentDates)
            ->orderBy('date', 'asc')
            ->orderBy('periode', 'asc')
            ->get()
            ->groupBy('date');

        $emploiDuTemps = [];
        foreach ($seances as $date => $listeSeances) {
            $emploiDuTemps[$date] = [
                'matin' => $listeSeances->where('periode', 'matin')->values(),
                'soir' => $listeSeances->where('periode', 'soir')->values()
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
        ], 200);
    }
}

