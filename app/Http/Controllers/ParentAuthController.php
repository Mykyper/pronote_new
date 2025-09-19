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
    // Méthode pour gérer la connexion des parents
   public function login(Request $request): JsonResponse
    {
        // Validation des données
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // Recherche du parent
        $parent = ParentModel::where('email', $request->email)->first();

        // Vérification des informations
        if ($parent && Hash::check($request->password, $parent->password)) {
            

            return response()->json([
                'success' => true,
                'message' => 'Connexion réussie !',
                'parent' => [
                    'id' => $parent->id,
                    'nom' => $parent->nom,
                    'prenom' => $parent->prenom,
                    'email' => $parent->email,
                ],
            ], 200);
        }

        // En cas d'erreur
        return response()->json([
            'success' => false,
            'message' => 'Email ou mot de passe incorrect.',
        ], 401);
    }
    // Méthode pour afficher la page d'accueil des parents
    public function showParentDashboard(Request $request)
    {
        // Obtenir l'ID du parent connecté depuis la session
        $parentId = $request->session()->get('parent_id');
    
        // Vérifier si l'ID du parent est disponible
        if (!$parentId) {
            return redirect('/parent-log')->with('error', 'Vous devez être connecté pour voir cette page.');
        }
    
        // Récupérer le parent et ses enfants
        $parent = ParentModel::with('eleves.classe')->find($parentId);
    
        // Vérifier si le parent et ses enfants sont trouvés
        if (!$parent || !$parent->eleves) {
            return redirect('/login')->with('error', 'Parent ou enfants non trouvés.');
        }
    
        // Récupérer les enfants
        $enfants = $parent->eleves;
    
        // Assurez-vous que vous avez des enfants
        if ($enfants->isEmpty()) {
            return view('parent_schedule')->with('message', 'Aucun enfant trouvé pour ce parent.');
        }
    
        // Récupérer les IDs des enfants et les IDs des classes
        $enfantsIds = $enfants->pluck('id');
        $classesIds = $enfants->pluck('classe_id');
    
        // Récupérer les 5 dates les plus récentes avec des séances pour les classes des enfants
        $recentDates = Seance::whereIn('class_id', $classesIds)
            ->orderBy('date', 'asc') // Dates les plus récentes en premier
            ->distinct('date') // Assurer l'unicité des dates
            ->pluck('date')
            ->take(5) // Limiter aux 5 dates les plus récentes
            ->toArray();
    
        // Récupérer toutes les séances pour les dates sélectionnées et les classes des enfants
        $seances = Seance::whereIn('class_id', $classesIds)
            ->whereIn('date', $recentDates)
            ->orderBy('date', 'desc')
            ->orderBy('periode', 'asc') // Assurer que les séances du matin viennent avant celles du soir
            ->get()
            ->groupBy(function ($seance) {
                return $seance->date; // Grouper par date
            });
    
        // Préparer le tableau d'emploi du temps
        $emploiDuTemps = [];
        foreach ($recentDates as $date) {
            $emploiDuTemps[$date] = [
                'matin' => $seances->get($date)->where('periode', 'matin') ?? collect(),
                'soir'  => $seances->get($date)->where('periode', 'soir') ?? collect()
            ];
        }
    
        return view('parent_interface', [
            'emploiDuTemps' => $emploiDuTemps,
            'eleves' => $enfants, // Passer les enfants à la vue pour le dropdown
            'parentNom' => $parent->nom,
            'parentPrenom' => $parent->prenom
        ]);
    }
    
    }


