<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presence;
use App\Models\Eleve;
use App\Models\Seance;

class PresenceController extends Controller
{
    /**
     * Afficher la page de présence pour un enseignant
     */
    public function show($sessionId)
    {
        if (!session()->has('teacher_id')) {
            return redirect('/teacher/login')
                ->with('error', 'Vous devez être connecté pour enregistrer des données.');
        }

        $seance = Seance::findOrFail($sessionId);
        $eleves = Eleve::where('classe_id', $seance->class_id)->get();

        return view('presence_prof', compact('eleves', 'sessionId', 'seance'));
    }

    /**
     * Récupérer les élèves pour une séance (API)
     */
    public function apiShow($sessionId)
    {
        // if (!session()->has('teacher_id')) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Vous devez être connecté pour accéder aux données.'
        //     ], 401);
        // }

        $seance = Seance::findOrFail($sessionId);
        $eleves = Eleve::where('classe_id', $seance->class_id)->get();

        return response()->json([
            'success' => true,
            'seance' => $seance,
            'eleves' => $eleves
        ]);
    }

    /**
     * Enregistrer les présences (enseignant ou coordinateur)
     */
    public function apiStore(Request $request)
    {
        // // Déterminer le type d'utilisateur
        // $userType = session()->has('teacher_id') ? 'teacher_id' : (session()->has('coordinator_id') ? 'coordinator_id' : null);

        // if (!$userType) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Vous devez être connecté pour enregistrer les présences.'
        //     ], 401);
        // }

        $data = $request->input('presences', []);
        $seanceId = $request->input('seance_id');

        $newPresences = 0;
        $existingPresences = 0;
        if (!$seanceId) {
    return response()->json([
        'success' => false,
        'message' => 'seance_id manquant !'
    ], 400);
}
        foreach ($data as $eleveId => $status) {
            $existingPresence = Presence::where('eleve_id', $eleveId)
                                        ->where('seance_id', $seanceId)
                                        ->first();

            if ($existingPresence) {
                $existingPresences++;
                continue;
            }

            Presence::create([
                'eleve_id' => $eleveId,
                'seance_id' => $seanceId,
                'status' => $status,
            ]);
            $newPresences++;
        }

        return response()->json([
            'success' => true,
            'message' => "$newPresences nouvelles présences enregistrées. $existingPresences existaient déjà."
        ]);
    }

    /**
     * Récupérer les présences pour le coordinateur (API)
     */
    public function apiShowCord($seanceId)
    {
        if (!session()->has('coordinator_id')) {
            return response()->json([
                'success' => false,
                'message' => 'Vous devez être connecté pour accéder aux données.'
            ], 401);
        }

        $seance = Seance::findOrFail($seanceId);
        $eleves = Eleve::where('classe_id', $seance->class_id)->get();
        $presences = Presence::where('seance_id', $seanceId)->get();

        return response()->json([
            'success' => true,
            'seance' => $seance,
            'eleves' => $eleves,
            'presences' => $presences
        ]);
    }
}
