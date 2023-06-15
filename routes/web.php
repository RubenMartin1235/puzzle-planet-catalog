<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PlanetController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\PurchaseController;
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
    Route::get('/dashboard/planets', [DashboardController::class, 'planets'])->name('dashboard.planets');
    Route::get('/dashboard/cards', [DashboardController::class, 'cards'])->name('dashboard.cards');
    Route::get('/dashboard/comments', [DashboardController::class, 'comments'])->name('dashboard.comments');
    Route::get('/dashboard/topup', [DashboardController::class, 'topup'])->name('dashboard.topup');
    Route::put('/dashboard/topup', [DashboardController::class, 'topupAction'])->name('dashboard.topup.action');

    Route::get('/planets/create', [PlanetController::class, 'create'])->name('planets.create');
    Route::post('/planets', [PlanetController::class, 'store'])->name('planets.store');
    Route::get('/planets/{planet}/edit', [PlanetController::class, 'edit'])->name('planets.edit');
    Route::put('/planets/{planet}/update', [PlanetController::class, 'update'])->name('planets.update');
    Route::delete('/planets/{planet}/destroy', [PlanetController::class, 'destroy'])->name('planets.destroy');
    Route::delete('/planets/destroy', [PlanetController::class, 'destroy'])->name('planets.destroy');

    Route::get('/planets/{planet}/comment', [CommentController::class, 'createOnPlanet'])->name('planets.comments.create');
    Route::post('/planets/{planet}/store', [CommentController::class, 'storeOnPlanet'])->name('planets.comments.store');
    Route::get('/cards/{card}/comment', [CommentController::class, 'createOnCard'])->name('cards.comments.create');
    Route::post('/cards/{card}/store', [CommentController::class, 'storeOnCard'])->name('cards.comments.store');

    Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::put('/comments/{comment}/update', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}/destroy', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::delete('/comments/destroy', [CommentController::class, 'destroy'])->name('comments.destroy');

    Route::get('/cards/{card}', [CardController::class, 'show'])->name('cards.show');

    Route::post('/purchases/add/card/{card}', [PurchaseController::class, 'addCard'])->name('purchases.cards.add');
    Route::delete('/purchases/remove/item/{item}', [PurchaseController::class, 'removeItem'])->name('purchases.items.remove');
    Route::get('/purchases/confirm', [PurchaseController::class, 'showConfirmation'])->name('purchases.confirm.show');
    Route::post('/purchases/confirm', [PurchaseController::class, 'confirm'])->name('purchases.confirm');
});
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard/users', [DashboardController::class, 'users'])->name('dashboard.users');
    Route::get('/dashboard/users/edit/{user}', [DashboardController::class, 'userEdit'])->name('dashboard.users.edit');
    Route::patch('/dashboard/users/update/{user}', [DashboardController::class, 'userUpdate'])->name('dashboard.users.update');
    Route::get('/dashboard/users/delete/{user}', [DashboardController::class, 'userDelete'])->name('dashboard.users.delete');
    Route::delete('/dashboard/users/destroy/{user}', [DashboardController::class, 'userDestroy'])->name('dashboard.users.destroy');

    Route::get('/dashboard/purchases', [DashboardController::class, 'purchases'])->name('dashboard.purchases');
});

Route::get('/planets', [PlanetController::class, 'index'])->name('planets.index');
Route::get('/planets/{planet}', [PlanetController::class, 'show'])->name('planets.show');
Route::get('/cards', [CardController::class, 'index'])->name('cards.index');

require __DIR__.'/auth.php';
