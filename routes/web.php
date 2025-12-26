<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\ReclamationController;
use App\Http\Controllers\StudentAuthController;
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

Route::get('/suivi-demande', [DemandeController::class, 'suiviForm'])->name('demande.suivi.form');
Route::post('/suivi-demande', [DemandeController::class, 'suiviCheck'])->name('demande.suivi.check');

// Authentification de l'étudiant (héritage de l'ancienne logique, conservée pour compatibilité)
Route::post('/login', [StudentAuthController::class, 'login'])->name('student.login');
Route::get('/logout', [StudentAuthController::class, 'logout'])->name('student.logout');
// Endpoint de lookup pour pré-remplir les infos étudiant depuis le formulaire unifié
Route::get('/api/etudiants/lookup', [StudentAuthController::class, 'lookup'])->name('etudiants.lookup');


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
    Route::get('/historique', [GestionDemandeController::class, 'historique'])->name('admin.historique');
    Route::get('/demandes/{id}/document', [GestionDemandeController::class, 'showDocument'])->name('admin.demandes.document');
    Route::post('/demandes/{id}/valider', [GestionDemandeController::class, 'valider'])->name('admin.demandes.valider');
    Route::post('/demandes/{id}/refuser', [GestionDemandeController::class, 'refuser'])->name('admin.demandes.refuser');
    Route::get('/reclamations', [GestionReclamationController::class, 'index'])->name('admin.reclamations');
    Route::post('/reclamations/{id}/traiter', [GestionReclamationController::class, 'traiter'])->name('admin.reclamations.traiter');

    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});


// --- ESPACE ÉTUDIANT UNIFIÉ (sans session préalable) ---
Route::get('/demande-reclamation', function () {
    return view('demande_reclamation');
})->name('demande_reclamation.formulaire');

// Compatibilité : anciennes routes redirigent vers la nouvelle page
Route::get('/nouvelle-demande', function () {
    return redirect()->route('demande_reclamation.formulaire');
})->name('demande.formulaire');
Route::get('/reclamation', function () {
    return redirect()->route('demande_reclamation.formulaire', ['preSelectReclamation' => true]);
})->name('reclamation.formulaire');

// Soumissions
Route::post('/nouvelle-demande', [DemandeController::class, 'store'])->name('demande.store');
Route::post('/reclamation', [ReclamationController::class, 'store'])->name('reclamation.store');

// Pages de succès (accessibles sans session)
Route::get('/demande/succes', function() {
    return view('demande_succes');
})->name('demande.succes');
Route::get('/reclamation/succes', function() {
    return view('reclamation_succes');
})->name('reclamation.succes');

