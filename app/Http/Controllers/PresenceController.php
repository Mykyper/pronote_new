<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presence;
use App\Models\Eleve;
use App\Models\Seance;

class PresenceController extends Controller
{
    public function show($sessionId)
    {    if (!session()->has('teacher_id')) {
        return redirect('/teacher/login')->with('error', 'Vous devez être connecté pour enregistrer des données.');
    }
        $seance = Seance::findOrFail($sessionId); // Utilisez le modèle correct
        $eleves = Eleve::where('classe_id', $seance->class_id)->get();
        
        return view('presence_prof', [
            'eleves' => $eleves,
            'sessionId' => $sessionId,
        ]);
    }

     public function store(Request $request)
    {    if (!session()->has('teacher_id')) {
        return redirect('/teacher/login')->with('error', 'Vous devez être connecté pour enregistrer des données.');
    }
        $data = $request->input('presences');
        $sessionId = $request->input('session_id');

        $newPresences = 0;
        $existingPresences = 0;

        foreach ($data as $eleveId => $status) {
            // Vérifier si la présence existe déjà
            $existingPresence = Presence::where('eleve_id', $eleveId)
                                        ->where('seance_id', $sessionId)
                                        ->first();

            if ($existingPresence) {
                $existingPresences++;
                continue; // Passer au prochain élève si la présence existe déjà
            }

            // Créer une nouvelle présence si elle n'existe pas
            Presence::create([
                'eleve_id' => $eleveId,
                'seance_id' => $sessionId,
                'status' => $status,
            ]);
            $newPresences++;
        }

        return redirect()->back()->with('success', "$newPresences présences enregistrées avec succès. $existingPresences présences existaient déjà.");
    }
    public function showPresenceDetails($seance_id)
{
      
      $seance = Seance::findOrFail($seance_id);

    
      $classe = $seance->classe;
  
    
      $eleves = Eleve::where('classe_id', $classe->id)->get();
  
   
      $presences = Presence::where('seance_id', $seance_id)->get();
  
      return view('presence_cord', compact('seance', 'eleves', 'presences'));
}
public function cordstore(Request $request)
{
     // Vérifier si l'id du coordinateur est stocké dans la session
    if (!session()->has('coordinator_id')) {
        return redirect('/coordinator-login')->with('error', 'Vous devez être connecté pour enregistrer les présences.');
    }
    // Récupérer les données de présence envoyées depuis le formulaire
    $data = $request->input('presences');
    $seanceId = $request->input('seance_id'); // Utiliser 'seance_id' au lieu de 'session_id'

    // Variables pour compter les nouvelles présences et les présences existantes
    $newPresences = 0;
    $existingPresences = 0;

    foreach ($data as $eleveId => $status) {
        // Vérifier si la présence pour cet élève et cette séance existe déjà
        $existingPresence = Presence::where('eleve_id', $eleveId)
                                    ->where('seance_id', $seanceId)
                                    ->first();

        if ($existingPresence) {
            // Incrémenter le compteur de présences existantes et passer au prochain élève
            $existingPresences++;
            continue;
        }

        // Créer une nouvelle présence si elle n'existe pas déjà
        Presence::create([
            'eleve_id' => $eleveId,
            'seance_id' => $seanceId,
            'status' => $status,
        ]);
        $newPresences++;
    }

    // Rediriger avec un message de succès incluant le nombre de nouvelles présences créées et celles déjà existantes
    return redirect()->back()->with('success', "$newPresences nouvelles présences enregistrées avec succès. $existingPresences présences existaient déjà.");
}


    
    

}