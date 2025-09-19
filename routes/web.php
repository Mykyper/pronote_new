<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentAuthController;
use App\Http\Controllers\TeacherAuthController;
use App\Http\Controllers\CoordinatorAuthController;
use App\Http\Controllers\SeanceController;
use App\Http\Controllers\CoordinateurController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\GraphController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ParentAuthController;

// Page Admin
Route::get('/admin', function () {
    return view('admin');
})->name('admin');
// Routes de page
Route::get('/', function () {
    return view('accueil');
});

Route::get('/student-log', function () {
    return view('eleve_log');
});

Route::get('/parent-log', function () {
    return view('parent_log');
});

Route::get('/master-log', function () {
    return view('master_log');
});

Route::get('/coordinator-log', function () {
    return view('coord_log');
});

Route::get('/parent-interface', function () {
    return view('parent-interface');
});

Route::get('/student-interface', function () {
    return view('eleve_interface');
})->name('student-inter');

Route::get('/teacher-interface', function () {
    return view('prof_interface');
})->name('teacher-inter');

// Routes de création
Route::get('/emplois-du-temps/create', [SeanceController::class, 'create'])->name('schedule.create');
Route::get('/parents/create', [ParentController::class, 'create'])->name('parents.create');
// web.php
Route::get('/students/create', [StudentController::class, 'showForm'])->name('students.create');

Route::get('/users/create', [UserController::class, 'index'])->name('users.create');
Route::get('/modules/create', [ModuleController::class, 'create'])->name('modules.create');

// Routes de fonction
Route::get('/eleve_interface', [StudentAuthController::class, 'show'])->name('eleve_interface.show');

Route::post('/presence', [PresenceController::class, 'store'])->name('presence.store');
Route::get('/presence/{sessionId}', [PresenceController::class, 'show'])->name('presence.show');

Route::post('/parents', [ParentController::class, 'store'])->name('parents.store');
Route::post('/students', [StudentController::class, 'store'])->name('students.store');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::post('/modules', [ModuleController::class, 'store'])->name('modules.store');
Route::post('/emplois-du-temps', [SeanceController::class, 'store'])->name('schedule.store');

Route::get('/api/parents', [ParentController::class, 'index'])->name('parents.index');
Route::get('/api/classes', [ClasseController::class, 'index'])->name('classes.index');

// Routes d'authentification
// Étudiants
Route::get('/student-login', [StudentAuthController::class, 'showLoginForm'])->name('student.login.form');
Route::post('/student-login', [StudentAuthController::class, 'login'])->name('student.login');

// Enseignants
Route::get('/teacher/login', [TeacherAuthController::class, 'showLoginForm'])->name('teacher-login');
Route::post('/teacher/login', [TeacherAuthController::class, 'login'])->name('teacher-login.post');
Route::get('/teacher/interface', [TeacherAuthController::class, 'show'])->name('teacher-interface.show');

// Coordinateurs
Route::get('/coordinator-login', [CoordinatorAuthController::class, 'showLoginForm'])->name('coordinator.login.form');
Route::post('/coordinator-login', [CoordinatorAuthController::class, 'login'])->name('coordinator.login');

// Parents
Route::post('/parent-login', [ParentAuthController::class, 'login'])->name('parent.login');
Route::get('/parent/dashboard', [ParentAuthController::class, 'showParentDashboard'])->name('parent.dashboard');

// Routes de coordinateur
Route::get('/coordinator-interface/{classId?}', [CoordinateurController::class, 'showInterface'])->name('coord-inter');
Route::get('/coordinateur/timetable/{classId}', [CoordinateurController::class, 'showTimetable'])->name('coordinateur.timetable.show');

// Routes de présence
Route::get('/presence-cord/{seance_id}', [PresenceController::class, 'showPresenceDetails'])->name('presence_cord.details');
Route::post('/presence-cord/{seance_id}', [PresenceController::class, 'cordstore'])->name('presence_cord.store');

// Routes de graphique
Route::get('/graphiques', [GraphController::class, 'index'])->name('graphiques.index');
Route::get('/taux-par-classe', [GraphController::class, 'tauxParClasse'])->name('taux_par_classe');
Route::get('/taux-par-module', [GraphController::class, 'tauxParModule'])->name('taux_par_module');

Route::post('/logout-cord', function () {
    session()->flush(); // Supprimer toutes les données de session
    return redirect('/');
})->name('logout');
Route::post('/parent/logout', [ParentController::class, 'logout'])->name('parent.logout');