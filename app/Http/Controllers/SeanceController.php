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
        if (!session()->has('coordinator_id')) {
            return redirect('/coordinator-login')->with('error', 'Vous devez être connecté pour enregistrer les présences.');
        }
        $classes = Classe::all();
        $modules = Module::all();
        $enseignants = User::where('role', 'enseignant')->get();
        
        return view('emploi', compact('classes', 'modules', 'enseignants'));
    }

    public function store(Request $request)
    {if (!session()->has('coordinator_id')) {
        return redirect('/coordinator-login')->with('error', 'Vous devez être connecté pour enregistrer les présences.');
    }
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
            // Create morning session
            if ($daySchedule['morning_module_id'] && $daySchedule['morning_teacher_id']) {
                Seance::create([
                    'class_id' => $request->input('class_id'),
                    'date' => $daySchedule['day'],
                    'periode' => 'matin',
                    'module_id' => $daySchedule['morning_module_id'],
                    'enseignant_id' => $daySchedule['morning_teacher_id'],
                ]);
            }

            // Create evening session
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

        return redirect()->route('schedule.create')->with('success', 'Emploi du temps enregistré avec succès.');
    }
}
