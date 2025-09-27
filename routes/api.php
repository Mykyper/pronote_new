<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ParentAuthController,
    StudentAuthController,
    TeacherAuthController,
    CoordinatorAuthController,
    SeanceController,
    ParentController,
    StudentController,
    UserController,
    ModuleController,
    ClasseController,
    PresenceController,
    GraphController
};

/*
|--------------------------------------------------------------------------
| API Utilisateurs et Authentification
|--------------------------------------------------------------------------
*/
// Étudiants
Route::post('/student-login', [StudentAuthController::class, 'login']);
Route::get('/student/schedule', [StudentAuthController::class, 'showEmploi']);
Route::get('/students', [StudentController::class, 'index']);

// Parents
Route::post('/parent-login', [ParentAuthController::class, 'login']);
Route::post('/parent-logout', [ParentAuthController::class, 'logout']);
Route::get('/parents', [ParentController::class, 'index']);
Route::post('/parents', [ParentController::class, 'store']);

// Enseignants
Route::post('/teacher-login', [TeacherAuthController::class, 'login']);

Route::get('/teacher/emploi/{teacherId}', [TeacherAuthController::class, 'getEmploiDuTemps']);

// Login coordinateur via API
Route::post('/coordinator-login', [CoordinatorAuthController::class, 'login']);

// Classes
Route::get('/classes', [ClasseController::class, 'index']);

// Modules
Route::post('/modules', [ModuleController::class, 'store']);
Route::get('/modules', [ModuleController::class, 'index']);

// Emplois du temps (Séances)
Route::get('/seances', [SeanceController::class, 'index']);
Route::post('/schedule/store', [SeanceController::class, 'store'])->name('api.schedule.store');
Route::get('/seances/eleve/{eleveId}', [SeanceController::class, 'getSeancesByEleve']);


// Présence
Route::get('/presences/{sessionId}', [PresenceController::class, 'apiShow']);
Route::post('/presences/store', [PresenceController::class, 'apiStore']);
Route::post('/presences/cordstore', [PresenceController::class, 'apiCordStore']);

// Graphiques
Route::get('/graphs', [GraphController::class, 'index']);
Route::get('/taux-par-classe', [GraphController::class, 'tauxParClasse']);
Route::get('/taux-par-module', [GraphController::class, 'tauxParModule']);
