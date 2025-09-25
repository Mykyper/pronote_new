<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classe;
use App\Models\Module;
use App\Models\User; // Assumant que les enseignants sont des utilisateurs
use App\Models\Seance;

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


}
