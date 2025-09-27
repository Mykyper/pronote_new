<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Seance;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse; 

class TeacherAuthController extends Controller
{
    // Afficher le formulaire de connexion des enseignants
    public function showLoginForm()
    {
        return view('master_log'); // Formulaire de login
    }

    // Traiter la connexion des enseignants
 public function login(Request $request): JsonResponse
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string|min:6',
    ]);

    $teacher = User::where('email', $request->email)
        ->where('role', 'enseignant')
        ->first();

    if ($teacher && Hash::check($request->password, $teacher->password)) {
        session(['teacher_id' => $teacher->id]);

        return response()->json([
            'success' => true,
            'message' => 'Connexion réussie !',
            'redirect' => route('teacher.dashboard'),
            'teacher' => [
                'id' => $teacher->id,
                'nom' => $teacher->nom,
                'prenom' => $teacher->prenom,
                'email' => $teacher->email,
            ]
        ], 200);
    }

    return response()->json([
        'success' => false,
        'message' => 'Email ou mot de passe incorrect.',
    ], 401);
}



    // Déconnexion de l'enseignant
    public function logout(Request $request)
    {
        $request->session()->forget('teacher_id');
        return redirect('/');
    }

    // Afficher le dashboard enseignant
 public function showTeacherDashboard(Request $request)
{
    $teacherId = $request->session()->get('teacher_id');

    if (!$teacherId) {
        return redirect('/teacher/login')->with('error', 'Vous devez être connecté.');
    }

    $teacher = User::find($teacherId);
    if (!$teacher) {
        return redirect('/teacher/login')->with('error', 'Enseignant introuvable.');
    }

    $seances = Seance::where('enseignant_id', $teacherId)
        ->orderBy('date', 'asc')
        ->get()
        ->groupBy('date');

    // Réorganiser les séances par matin/soir
    $emploiDuTemps = [];
    foreach ($seances as $date => $sessions) {
        $emploiDuTemps[$date] = [
            'matin' => $sessions->where('periode', 'matin'),
            'soir'  => $sessions->where('periode', 'soir'),
        ];
    }

    return view('prof_interface', [
        'teacherName' => $teacher->nom . ' ' . $teacher->prenom,
        'emploiDuTemps' => $emploiDuTemps,
    ]);
}


    // Récupérer l'emploi du temps via AJAX si nécessaire
    public function getEmploiDuTemps($teacherId)
    {
        $seances = Seance::where('enseignant_id', $teacherId)
            ->orderBy('date', 'asc')
            ->get()
            ->groupBy('date');

        return response()->json($seances);
    }
}
