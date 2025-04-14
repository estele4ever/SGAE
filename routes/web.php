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


    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        });

    Route::get('/archives/index', [ArchiveController::class, 'index'])->name('archives.index');
    Route::get('/archives/create', [ArchiveController::class, 'create'])->name('archives.create');
    Route::post('/archives/store', [ArchiveController::class, 'store'])->name('archives.store');
    Route::get('/archives/{id}', [ArchiveController::class, 'show'])->name('archives.show');
    Route::delete('/archives/{id}', [ArchiveController::class, 'destroy'])->name('archives.destroy');

    Route::get('/archive/{id}', [ArchiveController::class, 'show'])->middleware('service.check');




    Route::prefix('settings')->middleware('auth')->group(function () {
        Route::get('/security', [SettingsController::class, 'security'])->name('settings.security');
    // Route::get('/services', [SettingsController::class, 'services'])->name('settings.services');
        Route::get('/archives', [SettingsController::class, 'archives'])->name('settings.archives');
        Route::get('/storage', [SettingsController::class, 'storage'])->name('settings.storage');
        Route::get('/statistics', [SettingsController::class, 'statistics'])->name('settings.statistics');

        // Routes pour gere les securites
        Route::get('/security', [SettingsController::class, 'editUsers'])->name('settings.editUsers');


        // Routes pour gérer les services
        Route::post('/services/add', [SettingsController::class, 'addService'])->name('settings.addService');
        Route::delete('/services/{id}/delete', [SettingsController::class, 'deleteService'])->name('settings.deleteService');
        Route::get('/settings/services', [SettingsController::class, 'services'])->name('settings.services');
        Route::post('/settings/services', [SettingsController::class, 'storeService'])->name('settings.storeService');
        
        Route::patch('/settings/services/{id}/status', [SettingsController::class, 'updateServiceStatus'])->name('settings.updateServiceStatus');
        // Routes pour gérer les types d'archives
        Route::post('/archives/add', [SettingsController::class, 'addArchiveType'])->name('settings.addArchiveType');
        Route::put('/archives/updateArchiveType/{id}', [SettingsController::class, 'updateArchiveType'])->name('settings.updateArchiveType');
        Route::delete('/archives/{id}/delete', [SettingsController::class, 'deleteArchiveType'])->name('settings.deleteArchiveType');

        // Routes pour la gestion du stockage
        Route::post('/storage/clear', [SettingsController::class, 'clearStorage'])->name('settings.clearStorage');
    });



    //////////////manage des users///////////////////////

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

require __DIR__.'/auth.php';
