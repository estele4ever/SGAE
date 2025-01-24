<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArchiveController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/archives', [ArchiveController::class, 'index'])->name('archives.index');
Route::get('/archives/create', [ArchiveController::class, 'create'])->name('archives.create');
Route::post('/archives', [ArchiveController::class, 'store'])->name('archives.store');
Route::get('/archives/{id}', [ArchiveController::class, 'show'])->name('archives.show');
Route::delete('/archives/{id}', [ArchiveController::class, 'destroy'])->name('archives.destroy');


require __DIR__.'/auth.php';
