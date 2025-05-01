<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

    Route::get('/', function () {return view('welcome');});



    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');


    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
    Route::get('/Accueil', [DashboardController::class, 'accueil'])->middleware(['auth', 'verified'])->name('Accueil');

    Route::get('/aide', function () {
        return view('aide');
    })->name('aide');
    
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        });

    Route::get('/archives/index', [ArchiveController::class, 'index'])->name('archives.index');
    Route::get('/archives/edit/{id}', [ArchiveController::class, 'edit'])->name('archives.edit');
    Route::get('/archives/create', [ArchiveController::class, 'create'])->name('archives.create');
    Route::post('/archives/store', [ArchiveController::class, 'store'])->name('archives.store');
    Route::get('/archives/{id}', [ArchiveController::class, 'show'])->name('archives.show');
    Route::delete('/archives/{id}', [ArchiveController::class, 'destroy'])->name('archives.destroy');
    Route::get('/archives/{id}/telecharger', [ArchiveController::class, 'telecharger'])->name('archives.telecharger');
    Route::post('/archives/{id}/geler', [ArchiveController::class, 'geler'])->name('archives.geler');

    Route::get('/archive/{id}', [ArchiveController::class, 'show'])->middleware('service.check');




    Route::prefix('settings')->middleware('auth')->group(function () {
        Route::get('/security', [SettingsController::class, 'security'])->name('settings.security');
    // Route::get('/services', [SettingsController::class, 'services'])->name('settings.services');
        Route::get('/archives', [SettingsController::class, 'archives'])->name('settings.archives');
        Route::get('/statistics', [SettingsController::class, 'statistics'])->name('settings.statistics');

        // Routes pour gere les securites
        Route::get('/security', [SettingsController::class, 'editUsers'])->name('settings.editUsers');


        // Routes pour gérer les services
        Route::post('/services/add', [SettingsController::class, 'addService'])->name('settings.addService');
        Route::delete('/services/{id}/delete', [SettingsController::class, 'deleteService'])->name('settings.deleteService');
        Route::get('/settings/services', [SettingsController::class, 'services'])->name('settings.services');
        Route::post('/settings/services', [SettingsController::class, 'storeService'])->name('settings.storeService');
        Route::put('/archives/updateservice/{id}', [SettingsController::class, 'updateservice'])->name('settings.updateservice');
        Route::patch('/settings/services/{id}/status', [SettingsController::class, 'updateServiceStatus'])->name('settings.updateServiceStatus');
        
        
        
        // Routes pour gérer les types d'archives
        Route::post('/archives/add', [SettingsController::class, 'addArchiveProfile'])->name('settings.addArchiveProfile');
        Route::put('/archives/updateArchiveType/{id}', [SettingsController::class, 'updateArchiveType'])->name('settings.updateArchiveType');
        Route::delete('/archives/{id}/delete', [SettingsController::class, 'deleteArchiveType'])->name('settings.deleteArchiveType');
        Route::put('/archives/updateArchiveType/{id}', [SettingsController::class, 'updateArchiveType'])->name('settings.updateArchiveType');
        Route::patch('/settings/types/{id}/status', [SettingsController::class, 'updateTypeStatus'])->name('settings.updateTypeStatus');
        Route::get('/archive-profile/{id}/fields', [SettingsController::class, 'getProfileFields'])->name('settings.getProfileFields');
// Récupérer un profil d'archive par son ID
        Route::get('/archive-profile/{id}', [SettingsController::class, 'getProfile'])->name('settings.getProfile');

// Récupérer les champs d'un profil d'archive
        Route::get('/archive-profile/{id}/fields', [SettingsController::class, 'getProfileFields'])->name('settings.getProfileFields');
        Route::get('/archive-profile/{id}/edit', [SettingsController::class, 'editArchiveProfile'])->name('settings.editArchiveProfile');


        
        // Routes pour la gestion du stockage
        Route::post('/storage/clear', [SettingsController::class, 'clearStorage'])->name('settings.clearStorage');


        //regles de conservation
        Route::get('/regles', [SettingsController::class, 'regles'])->name('settings.regles');
        Route::post('/regles/add', [SettingsController::class, 'addRegle'])->name('settings.addRegle');
        Route::delete('/regles/{id}/delete', [SettingsController::class, 'deleteRegle'])->name('settings.deleteRegle');
        Route::get('/settings/regles', [SettingsController::class, 'regles'])->name('settings.regles');
        Route::post('/settings/regles', [SettingsController::class, 'storeRegle'])->name('settings.storeRegle');
        Route::put('/archives/updateregle/{id}', [SettingsController::class, 'updateregle'])->name('settings.updateregle');
        


        // Routes pour la gestion des rôles
        Route::get('/roles', [SettingsController::class, 'index'])->name('settings.roles');
        Route::post('/roles/add', [SettingsController::class, 'store'])->name('settings.addRole');
        Route::put('/roles/update/{id}', [SettingsController::class, 'update'])->name('settings.updateRole');
        Route::delete('/roles/{id}/delete', [SettingsController::class, 'destroy'])->name('settings.deleteRole');
    });



    //////////////manage des users///////////////////////

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

require __DIR__.'/auth.php';
