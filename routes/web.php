<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ParentController,
    ParentAuthController,
    StudentController,
    StudentAuthController,
    ClasseController,
    UserController,
    TeacherAuthController,
    CoordinatorAuthController,
    SeanceController,
    CoordinateurController,
    PresenceController,
    GraphController,
    ModuleController
};

/*
|--------------------------------------------------------------------------
| Pages publiques
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => view('accueil'));

Route::get('/student-log', fn() => view('eleve_log'));
Route::get('/master-log', fn() => view('master_log'));
Route::get('/coordinator-log', fn() => view('coord_log'));
Route::get('/teacher-interface', [TeacherAuthController::class, 'showTeacherDashboard'])
    ->name('teacher.interface');
Route::get('/admin', fn() => view('admin'))->name('admin');

/*
|--------------------------------------------------------------------------
| Authentification Étudiants
|--------------------------------------------------------------------------
*/
Route::get('/student-login-form', [StudentAuthController::class, 'showLoginForm'])->name('student.login.form');
Route::post('/student-login', [StudentAuthController::class, 'login'])->name('student.login');
Route::get('/student-interface', [StudentAuthController::class, 'interface'])->name('student-inter')->middleware('web');
Route::get('/student/emploi', [StudentAuthController::class, 'showEmploi'])->name('student.api.emploi')->middleware('web');

/*
|--------------------------------------------------------------------------
| Authentification Enseignants
|--------------------------------------------------------------------------
*/
Route::get('/teacher/login', [TeacherAuthController::class, 'showLoginForm'])->name('teacher-login');
Route::post('/teacher/login', [TeacherAuthController::class, 'login'])->name('teacher-login.post');
// Login via API (AJAX)
Route::post('/api/teacher-login', [TeacherAuthController::class, 'login'])->name('teacher.login');

Route::get('/teacher/dashboard', [TeacherAuthController::class, 'showTeacherDashboard'])
    ->name('teacher.dashboard')
    ->middleware('web');
    // API pour récupérer l'emploi du temps d'un enseignant (AJAX)
Route::get('/teacher/emploi/{teacherId}', [TeacherAuthController::class, 'getEmploiDuTemps']);
// Déconnexion
Route::post('/teacher/logout', [TeacherAuthController::class, 'logout'])->name('teacher.logout');

/*
|--------------------------------------------------------------------------
| Authentification Coordinateurs
|--------------------------------------------------------------------------
*/
Route::get('/coordinator-login', [CoordinatorAuthController::class, 'showLoginForm'])->name('coordinator.login.form');
Route::post('/coordinator-login', [CoordinatorAuthController::class, 'login'])->name('coordinator.login');
Route::get('/coordinator-interface/{classId?}', [CoordinateurController::class, 'showInterface'])->name('coord-inter');
Route::get('/coordinateur/timetable/{classId}', [CoordinateurController::class, 'showTimetable'])->name('coordinateur.timetable.show');

/*
|--------------------------------------------------------------------------
| Authentification Parents
|--------------------------------------------------------------------------
*/
// Formulaire et login
Route::get('/parent-login-form', [ParentAuthController::class, 'showLoginForm'])->name('parent.login.form');
Route::post('/parent-login', [ParentAuthController::class, 'login'])->name('parent.login');
Route::post('/parent/logout', [ParentAuthController::class, 'logout'])->name('parent.logout');

// Dashboard et AJAX pour emploi du temps
Route::get('/parent/dashboard', [ParentAuthController::class, 'showParentDashboard'])->name('parent.dashboard')->middleware('web');
Route::get('/parent/emploi/{enfantId}', [ParentAuthController::class, 'getEmploiDuTemps']);

/*
|--------------------------------------------------------------------------
| Création de ressources
|--------------------------------------------------------------------------
*/
Route::get('/students/create', [StudentController::class, 'showForm'])->name('students.create');
Route::get('/parents/create', [ParentController::class, 'create'])->name('parents.create');
Route::get('/users/create', [UserController::class, 'index'])->name('users.create');
Route::get('/modules/create', [ModuleController::class, 'create'])->name('modules.create');
Route::get('/emplois-du-temps/create', [SeanceController::class, 'create'])->name('schedule.create');

/*
|--------------------------------------------------------------------------
| Stockage de ressources
|--------------------------------------------------------------------------
*/
Route::post('/students', [StudentController::class, 'store'])->name('students.store');
Route::post('/parents', [ParentController::class, 'store'])->name('parents.store');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::post('/modules', [ModuleController::class, 'store'])->name('modules.store');
Route::post('/emplois-du-temps', [SeanceController::class, 'store'])->name('schedule.store');

/*
|--------------------------------------------------------------------------
| API et affichage de listes
|--------------------------------------------------------------------------
*/
Route::get('/api/parents', [ParentController::class, 'index'])->name('parents.index');
Route::get('/api/classes', [ClasseController::class, 'index'])->name('classes.index');
Route::get('/eleve_interface', [StudentAuthController::class, 'show'])->name('eleve_interface.show');

/*
|--------------------------------------------------------------------------
| Gestion des présences
|--------------------------------------------------------------------------
*/
Route::post('/presence', [PresenceController::class, 'store'])->name('presence.store');
Route::get('/presence/{sessionId}', [PresenceController::class, 'show'])->name('presence.show');
Route::get('/presence-cord/{seance_id}', [PresenceController::class, 'showPresenceDetails'])->name('presence_cord.details');
Route::post('/presence-cord/{seance_id}', [PresenceController::class, 'cordstore'])->name('presence_cord.store');

/*
|--------------------------------------------------------------------------
| Graphiques et statistiques
|--------------------------------------------------------------------------
*/
Route::get('/graphiques', [GraphController::class, 'index'])->name('graphiques.index');
Route::get('/taux-par-classe', [GraphController::class, 'tauxParClasse'])->name('taux_par_classe');
Route::get('/taux-par-module', [GraphController::class, 'tauxParModule'])->name('taux_par_module');

/*
|--------------------------------------------------------------------------
| Logout coordinateur
|--------------------------------------------------------------------------
*/
Route::post('/logout-cord', function () {
    session()->flush();
    return redirect('/');
})->name('logout');
