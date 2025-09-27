<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classe;
use App\Models\Module;
use App\Models\User; // Assumant que les enseignants sont des utilisateurs
use App\Models\Seance;
use Illuminate\Http\JsonResponse;
use App\Models\Eleve;

class SeanceController extends Controller
{
   public function create()
    {
        $classes = Classe::all();
        $modules = Module::all();

        // Si tes enseignants sont dans users avec role = 'enseignant'
        $teachers = User::where('role', 'enseignant')->get();

        // ou si tu as un model "Enseignant"
        // $teachers = Enseignant::all();

        return view('emploi', compact('classes', 'modules', 'teachers'));
    }

   public function store(Request $request)
{
    try {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'schedule' => 'required|array',
            'schedule.*.day' => 'required|string',
            'schedule.*.morning_module_id' => 'nullable|exists:modules,id',
            'schedule.*.morning_teacher_id' => 'nullable|exists:users,id',
            'schedule.*.evening_module_id' => 'nullable|exists:modules,id',
            'schedule.*.evening_teacher_id' => 'nullable|exists:users,id',
        ]);

        foreach ($request->input('schedule') as $daySchedule) {
            if ($daySchedule['morning_module_id'] && $daySchedule['morning_teacher_id']) {
                Seance::create([
                    'class_id' => $request->input('class_id'),
                    'date' => $daySchedule['day'],
                    'periode' => 'matin',
                    'module_id' => $daySchedule['morning_module_id'],
                    'enseignant_id' => $daySchedule['morning_teacher_id'],
                ]);
            }
            if ($daySchedule['evening_module_id'] && $daySchedule['evening_teacher_id']) {
                Seance::create([
                    'class_id' => $request->input('class_id'),
                    'date' => $daySchedule['day'],
                    'periode' => 'soir',
                    'module_id' => $daySchedule['evening_module_id'],
                    'enseignant_id' => $daySchedule['evening_teacher_id'],
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Emploi du temps enregistré avec succès.'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}
public function index(): JsonResponse
{
    try {
        // 🔍 Récupère toutes les séances avec leurs relations
        $seances = Seance::with(['module', 'enseignant', 'classe'])
            ->orderBy('date', 'desc')
            ->orderBy('periode', 'asc')
            ->get();

        // ✅ Réponse JSON
        return response()->json([
            'success' => true,
            'count' => $seances->count(),
            'seances' => $seances
        ]);
    } catch (\Exception $e) {
        // ⚠️ Gestion d’erreur
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}
public function getSeancesByEleve($eleveId): JsonResponse
{
    // 🔹 Récupérer l'élève
    $eleve = Eleve::find($eleveId);

    if (!$eleve) {
        return response()->json([
            'success' => false,
            'message' => 'Élève introuvable'
        ], 404);
    }

    // 🔹 Filtrer les séances selon la classe de l'élève
    $seances = Seance::with(['module', 'enseignant', 'classe'])
        ->where('classe_id', $eleve->classe_id)
        ->orderBy('date', 'desc')
        ->orderBy('periode', 'asc')
        ->get();

    return response()->json([
        'success' => true,
        'count' => $seances->count(),
        'seances' => $seances
    ]);
}


}
