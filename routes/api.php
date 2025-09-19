<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\SeanceController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\GraphController;
use App\Http\Controllers\StudentAuthController;
use App\Http\Controllers\TeacherAuthController;
use App\Http\Controllers\CoordinatorAuthController;
use App\Http\Controllers\ParentAuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

# ================================
# Utilisateurs
# ================================
Route::post('/users', [UserController::class, 'store']);
Route::get('/users', [UserController::class, 'all']);

# ================================
# Étudiants
# ================================
Route::get('/students/create', [StudentController::class, 'create']);
Route::post('/students', [StudentController::class, 'store']);
Route::get('/students', [StudentController::class, 'index']);
Route::post('/student-login', [StudentAuthController::class, 'login']);

# ================================
# Enseignants
# ================================
Route::post('/teacher-login', [TeacherAuthController::class, 'apiLogin']);
Route::get('/teacher-interface', [TeacherAuthController::class, 'apiShow']);

# ================================
# Coordinateurs
# ================================
Route::post('/coordinator-login', [CoordinatorAuthController::class, 'login']);

# ================================
# Parents
# ================================
Route::post('/parents', [ParentController::class, 'store']);
Route::get('/parents', [ParentController::class, 'index']);
Route::post('/parent-login', [ParentAuthController::class, 'login']);
Route::post('/parent-logout', [ParentAuthController::class, 'logout']);

# ================================
# Classes
# ================================
Route::get('/classes', [ClasseController::class, 'index']);

# ================================
# Modules
# ================================
Route::post('/modules', [ModuleController::class, 'store']);
Route::get('/modules', [ModuleController::class, 'index']);

# ================================
# Emplois du temps (séances)
# ================================
Route::post('/emplois-du-temps', [SeanceController::class, 'store']);
Route::get('/emplois-du-temps', [SeanceController::class, 'index']);

# ================================
# Présence
# ================================
Route::post('/presence', [PresenceController::class, 'store']);
Route::get('/presence/{sessionId}', [PresenceController::class, 'show']);

# ================================
# Graphiques
# ================================
Route::get('/graphs', [GraphController::class, 'index']);
Route::get('/taux-par-classe', [GraphController::class, 'tauxParClasse']);
Route::get('/taux-par-module', [GraphController::class, 'tauxParModule']);
