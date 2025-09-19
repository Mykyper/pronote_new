<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seance;
use App\Models\Classe;


class CoordinateurController extends Controller
{
    public function showInterface($classId = null)
    {
        // Vérifier si l'id du coordinateur est stocké dans la session
        if (!session()->has('coordinator_id')) {
            return redirect('/coordinator-login')->with('error', 'Vous devez être connecté pour accéder à cette page.');
        }
        $emploiDuTemps = [];
        $classe = null;
    
        if ($classId) {
            // Récupérer l'objet Classe
            $classe = Classe::find($classId);
    
            if ($classe) {
                // Récupérer les 5 dates les plus récentes où il y a des séances pour la classe sélectionnée
                $recentDates = Seance::where('class_id', $classId)
                    ->orderBy('date', 'asc')
                    ->take(10)
                    ->pluck('date')
                    ->unique()
                    ->toArray();
                
                // Pour chaque date, récupérer les séances du matin et du soir
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
            
                    $emploiDuTemps[$date]['matin'] = $seancesMatin;
                    $emploiDuTemps[$date]['soir'] = $seancesSoir;
                }
            }
        }
    
        // Passer les variables à la vue
        return view('interface_cord', compact('classe', 'emploiDuTemps'));
    }
}

