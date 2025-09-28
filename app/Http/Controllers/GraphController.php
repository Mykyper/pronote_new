<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presence;
use App\Models\Classe;
use App\Models\Module;

class GraphController extends Controller
{
    // Méthode pour afficher la page principale des graphiques
    public function index()
    { if (!session()->has('coordinator_id')) {
        return redirect('/coordinator-login')->with('error', 'Vous devez être connecté pour enregistrer les présences.');
    }
        // Cette méthode pourrait être utilisée pour afficher une vue d'accueil pour les graphiques
        return view('graph');
    }

    // Méthode pour calculer le taux de présence par classe
    public function tauxParClasse()
    { if (!session()->has('coordinator_id')) {
        return redirect('/coordinator-login')->with('error', 'Vous devez être connecté pour enregistrer les présences.');
    }
        // Récupérer toutes les classes avec les présences des élèves
        $classes = Classe::with('eleves.presences')->get();

        // Calculer le taux de présence pour chaque classe
        $tauxPresencesParClasse = [];

        foreach ($classes as $classe) {
            $totalPresences = 0;
            $totalSeances = 0;

            foreach ($classe->eleves as $eleve) {
                $totalPresences += $eleve->presences->where('status', 'présent')->count();
                $totalSeances += $eleve->presences->count();
            }

            $tauxPresencesParClasse[$classe->niveau . ' ' . $classe->specialite] = $totalSeances > 0 
                ? ($totalPresences / $totalSeances) * 100 
                : 0;
        }

        // Retourner la vue avec les données calculées
        return view('taux_par_classe', compact('tauxPresencesParClasse'));
    }

    // Méthode pour calculer le taux de présence par module
    public function tauxParModule()
    { if (!session()->has('coordinator_id')) {
        return redirect('/coordinator-login')->with('error', 'Vous devez être connecté pour enregistrer les présences.');
    }
        // Récupérer tous les modules avec les séances associées
        $modules = Module::with('seances.presences')->get();

        // Calculer le taux de présence pour chaque module
        $tauxPresencesParModule = [];

        foreach ($modules as $module) {
            $totalPresences = 0;
            $totalSeances = 0;

            foreach ($module->seances as $seance) {
                $totalPresences += $seance->presences->where('status', 'présent')->count();
                $totalSeances += $seance->presences->count();
            }

            $tauxPresencesParModule[$module->nom] = $totalSeances > 0 
                ? ($totalPresences / $totalSeances) * 100 
                : 0;
        }

        // Retourner la vue avec les données calculées
        return view('taux_par_module', compact('tauxPresencesParModule'));
    }

  
   
}




