<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Eleve;
use App\Models\Seance;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException; 
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
    // Validation
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required|string|min:6',
    ]);

    $eleve = Eleve::where('email', $credentials['email'])->first();

    if ($eleve && Hash::check($credentials['password'], $eleve->password)) {
        // Si tu veux stocker la session pour navigateur web, décommenter :
        session(['student_id' => $eleve->id]) ;

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
    // Vérifier que l'élève est connecté via session
    if (!$request->session()->has('student_id')) {
        return redirect()->route('student.login.form');
    }

    $studentId = $request->session()->get('student_id');
    $eleve = Eleve::find($studentId);

    return view('eleve_interface', compact('eleve'));
}

    // Récupérer l'emploi du temps (API)
    public function showEmploi(Request $request): JsonResponse
{
    // 🔐 Vérification de la session
    $studentId = $request->session()->get('student_id');

    if (!$studentId) {
        return response()->json([
            'success' => false,
            'message' => 'Vous devez être connecté pour accéder à cette ressource.'
        ], 401);
    }

    // 👤 Récupération de l’élève
    $eleve = Eleve::find($studentId);

    if (!$eleve || !$eleve->classe_id) {
        return response()->json([
            'success' => false,
            'message' => 'Erreur : élève introuvable ou classe non associée.'
        ], 400);
    }

    $classId = $eleve->classe_id;

    // 📅 Récupération des 10 dernières dates distinctes pour la classe
    $recentDates = Seance::where('class_id', $classId)
        ->orderBy('date', 'desc')
        ->pluck('date')
        ->unique()
        ->take(10)
        ->values()
        ->toArray();

    // 🧠 Récupération des séances associées à ces dates, avec les relations
    $seances = Seance::where('class_id', $classId)
        ->whereIn('date', $recentDates)
        ->with(['module', 'enseignant']) // inclure les relations pour éviter les requêtes multiples
        ->orderBy('date', 'asc')
        ->orderBy('periode', 'asc')
        ->get()
        ->groupBy('date');

    // 🧩 Organisation des données par date (matin / soir)
    $emploiDuTemps = [];

    foreach ($seances as $date => $listeSeances) {
        $emploiDuTemps[$date] = [
            'matin' => $listeSeances->where('periode', 'matin')->values(),
            'soir' => $listeSeances->where('periode', 'soir')->values(),
        ];
    }

    // ✅ Réponse JSON structurée
    return response()->json([
        'success' => true,
        'student' => [
            'id' => $eleve->id,
            'nom' => $eleve->nom,
            'prenom' => $eleve->prenom,
            'classe_id' => $classId,
        ],
        'emploiDuTemps' => $emploiDuTemps,
    ], 200);
}

}

