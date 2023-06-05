<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PlanetController;
use App\Http\Controllers\CommentController;
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

Route::middleware('auth')->group(function () {
    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/planets/create', [PlanetController::class, 'create'])->name('planets.create');
    Route::post('/planets', [PlanetController::class, 'store'])->name('planets.store');
    Route::get('/planets/{planet}/edit', [PlanetController::class, 'edit'])->name('planets.edit');
    Route::put('/planets/{planet}/update', [PlanetController::class, 'update'])->name('planets.update');
    Route::delete('/planets/{planet}/destroy', [PlanetController::class, 'destroy'])->name('planets.destroy');
    Route::delete('/planets/destroy', [PlanetController::class, 'destroy'])->name('planets.destroy');

    Route::get('/planets/{planet}/comment', [CommentController::class, 'createOnPlanet'])->name('planets.comments.create');
    Route::post('/planets/{planet}/store', [CommentController::class, 'storeOnPlanet'])->name('planets.comments.store');
    Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::put('/comments/{comment}/update', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}/destroy', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::delete('/comments/destroy', [CommentController::class, 'destroy'])->name('comments.destroy');
});
Route::get('/planets', [PlanetController::class, 'index'])->name('planets.index');
Route::get('/planets/{planet}', [PlanetController::class, 'show'])->name('planets.show');

require __DIR__.'/auth.php';
