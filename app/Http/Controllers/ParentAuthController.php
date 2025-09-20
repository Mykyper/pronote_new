<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParentModel;
use App\Models\Eleve;
use App\Models\Seance;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

class ParentAuthController extends Controller
{
    // Affiche le formulaire de login parent
    public function showLoginForm()
    {
        return view('parent_log'); // la vue Blade
    }

    // Connexion parent
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $parent = ParentModel::where('email', $request->email)->first();

        if ($parent && Hash::check($request->password, $parent->password)) {
            // Stocker l'ID parent en session
            $request->session()->put('parent_id', $parent->id);

            return response()->json([
                'success' => true,
                'message' => 'Connexion réussie !',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Email ou mot de passe incorrect.',
        ], 401);
    }

    // Dashboard parent
    public function showParentDashboard(Request $request)
    {
        $parentId = $request->session()->get('parent_id');

        if (!$parentId) {
            return redirect()->route('parent.login.form')
                             ->with('error', 'Vous devez être connecté.');
        }

        $parent = ParentModel::with('eleves.classe')->find($parentId);
        $enfants = $parent->eleves;

        if ($enfants->isEmpty()) {
            return view('parent_interface')->with('message', 'Aucun enfant trouvé.');
        }

        $classesIds = $enfants->pluck('classe_id');
        $recentDates = Seance::whereIn('class_id', $classesIds)
            ->orderBy('date', 'asc')
            ->distinct('date')
            ->pluck('date')
            ->take(5)
            ->toArray();

        $seances = Seance::whereIn('class_id', $classesIds)
            ->whereIn('date', $recentDates)
            ->orderBy('date', 'desc')
            ->orderBy('periode', 'asc')
            ->get()
            ->groupBy('date');

        $emploiDuTemps = [];
        foreach ($recentDates as $date) {
            $emploiDuTemps[$date] = [
                'matin' => $seances->get($date)->where('periode', 'matin') ?? collect(),
                'soir'  => $seances->get($date)->where('periode', 'soir') ?? collect()
            ];
        }

        return view('parent_interface', [
            'emploiDuTemps' => $emploiDuTemps,
            'eleves' => $enfants,
            'parentNom' => $parent->nom,
            'parentPrenom' => $parent->prenom
        ]);
    }

    // Déconnexion
    public function logout(Request $request)
    {
        $request->session()->forget('parent_id');
        return redirect()->route('parent.login.form');
    }
    public function getEmploiDuTemps($enfantId)
{
    $eleve = Eleve::with(['classe', 'classe.seances.module', 'classe.seances.enseignant'])
                  ->find($enfantId);

    if(!$eleve) {
        return response()->json(['success' => false]);
    }

    $classeId = $eleve->classe_id;

    $recentDates = Seance::where('class_id', $classeId)
        ->orderBy('date', 'asc')
        ->distinct('date')
        ->pluck('date')
        ->take(5)
        ->toArray();

    $seances = Seance::where('class_id', $classeId)
        ->whereIn('date', $recentDates)
        ->orderBy('date', 'desc')
        ->orderBy('periode', 'asc')
        ->get()
        ->groupBy('date');

    $emploiDuTemps = [];
    foreach($recentDates as $date){
        $emploiDuTemps[] = [
            'date' => $date,
            'matin' => $seances->get($date)->where('periode', 'matin')->map(function($s){ return ['module'=>$s->module->nom,'enseignant'=>$s->enseignant->nom]; }),
            'soir' => $seances->get($date)->where('periode', 'soir')->map(function($s){ return ['module'=>$s->module->nom,'enseignant'=>$s->enseignant->nom]; })
        ];
    }

    return response()->json(['success' => true, 'emploiDuTemps' => $emploiDuTemps]);
}

}
