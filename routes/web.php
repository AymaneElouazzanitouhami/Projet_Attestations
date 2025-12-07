<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentAuthController;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\ReclamationController;
use App\Http\Controllers\AdminAuthController; // On importe le contrôleur depuis le sous-dossier Admin
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GestionDemandeController;
use App\Http\Controllers\Admin\GestionReclamationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|-------------------------------
-------------------------------------------
*/

// --- ROUTES PUBLIQUES ---
Route::get('/', function () {
    return view('accueil');
})->name('home');

// Authentification de l'étudiant
Route::post('/login', [StudentAuthController::class, 'login'])->name('student.login');
Route::get('/logout', [StudentAuthController::class, 'logout'])->name('student.logout');


// --- ROUTES POUR L'ADMINISTRATION ---
// Affiche la page de connexion pour l'administrateur
Route::get('/administration/login', function () {
    return view('admin.login');
})->name('admin.login');

// Traite le formulaire de connexion admin en appelant le contrôleur
Route::post('/administration/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');



Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/demandes', [GestionDemandeController::class, 'index'])->name('admin.demandes');
    Route::get('/demandes/{id}/document', [GestionDemandeController::class, 'showDocument'])->name('admin.demandes.document');
    Route::post('/demandes/{id}/valider', [GestionDemandeController::class, 'valider'])->name('admin.demandes.valider');
    Route::post('/demandes/{id}/refuser', [GestionDemandeController::class, 'refuser'])->name('admin.demandes.refuser');
    Route::get('/reclamations', [GestionReclamationController::class, 'index'])->name('admin.reclamations');
    Route::post('/reclamations/{id}/traiter', [GestionReclamationController::class, 'traiter'])->name('admin.reclamations.traiter');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});


// --- ROUTES PROTÉGÉES (Espace Étudiant) ---
// Note : la logique de protection est directement dans chaque route pour le moment.

// Affiche la page de choix après une connexion réussie
Route::get('/espace-etudiant/choix', function() {
    if (!session('etudiant')) {
        return redirect()->route('home')->withErrors(['identification' => 'Veuillez vous connecter pour accéder à cet espace.']);
    }
    return view('choix');
})->name('choix.action');

// Routes pour la Demande d'Attestation
Route::get('/nouvelle-demande', function () {
    if (!session('etudiant')) { return redirect()->route('home'); }
    return view('demande', ['etudiant' => session('etudiant')]);
})->name('demande.formulaire');
Route::post('/nouvelle-demande', [DemandeController::class, 'store'])->name('demande.store');
Route::get('/demande/succes', function() {
    if (!session('etudiant')) { return redirect()->route('home'); }
    return view('demande_succes');
})->name('demande.succes');

// Routes pour la Réclamation
Route::get('/reclamation', function () {
    if (!session('etudiant')) { return redirect()->route('home'); }
    return view('reclamation', ['etudiant' => session('etudiant')]);
})->name('reclamation.formulaire');
Route::post('/reclamation', [ReclamationController::class, 'store'])->name('reclamation.store');
Route::get('/reclamation/succes', function() {
    if (!session('etudiant')) { return redirect()->route('home'); }
    return view('reclamation_succes');
})->name('reclamation.succes');
