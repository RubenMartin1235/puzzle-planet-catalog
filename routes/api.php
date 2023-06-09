<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController as ApiUserController;
use App\Http\Controllers\Api\PlanetController as ApiPlanetController;
use App\Http\Controllers\Api\BlockController as ApiBlockController;
use App\Http\Controllers\Api\CommentController as ApiCommentController;
use App\Http\Controllers\Api\RatingController as ApiRatingController;
use App\Http\Controllers\Api\CardController;
use App\Http\Controllers\Api\PurchaseController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



// USERS
Route::post('register', [ApiUserController::class, 'register']);
Route::post('login', [ApiUserController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('profile', [ApiUserController::class, 'profile']);
    Route::put('profile/update', [ApiUserController::class, 'profileUpdate']);
    Route::delete('profile/delete', [ApiUserController::class, 'profileDelete']);
    Route::get('logout', [ApiUserController::class, 'logout']);

    Route::get('users/{user}', [ApiUserController::class, 'show']);
    Route::put('profile/topup', [ApiUserController::class, 'topup']);
    Route::get('profile/cards', [ApiUserController::class, 'cardCollection']);
    Route::get('profile/roles', [ApiUserController::class, 'showRoles']);
});

Route::group(['middleware' => ['auth:sanctum', 'role:admin']], function () {
    Route::post('users', [ApiUserController::class, 'store']);
    Route::put('users/{user}', [ApiUserController::class, 'update']);
    Route::delete('users/{user}', [ApiUserController::class, 'destroy']);
    Route::put('users/{user}/topup', [ApiUserController::class, 'topup']);
    Route::get('users/{user}/cards', [ApiUserController::class, 'cardCollection']);

    Route::get('users/{user}/roles', [ApiUserController::class, 'showRoles']);
    Route::patch('users/{user}/roles', [ApiUserController::class, 'assignRoles']);
    Route::delete('users/{user}/roles', [ApiUserController::class, 'takeAwayRoles']);
});


// PLANETS
Route::get('planets/{planet}', [ApiPlanetController::class, 'show']);
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('planets', [ApiPlanetController::class, 'index']);
    Route::post('planets', [ApiPlanetController::class, 'store']);
    Route::put('planets/{planet}', [ApiPlanetController::class, 'update']);
    Route::delete('planets/{planet}', [ApiPlanetController::class, 'destroy']);

    Route::get('profile/planets', [ApiPlanetController::class, 'showOwn']);
    Route::get('users/{user}/planets', [ApiPlanetController::class, 'showByUser']);
});
Route::get('planets/{planet}/blocks', [ApiPlanetController::class, 'showBlocks']);

// BLOCKS
Route::get('blocks/{block}', [ApiBlockController::class, 'show']);
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('blocks', [ApiBlockController::class, 'index']);
});
Route::group(['middleware' => ['auth:sanctum', 'role:loader,admin']], function () {
    Route::post('blocks', [ApiBlockController::class, 'store']);
    Route::put('blocks/{block}', [ApiBlockController::class, 'update']);
    Route::delete('blocks/{block}', [ApiBlockController::class, 'destroy']);
});

// COMMENTS
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('comments/{comment}', [ApiCommentController::class, 'show']);    // Show comment by ID.
    Route::get('profile/comments', [ApiCommentController::class, 'showOwn']);           // Show comments of authenticated user.
    Route::get('planets/{planet}/comments', [ApiCommentController::class, 'showByPlanet']); // Show comments made on a planet.
    Route::get('cards/{card}/comments', [ApiCommentController::class, 'showByCard']); // Show comments made on a card.
    Route::get('users/{user}/comments', [ApiCommentController::class, 'showByUser']);       // Show comments made by another user.

    Route::post('planets/{planet}/comments', [ApiCommentController::class, 'storeOnPlanet']);       // Make comment on a planet.
    Route::post('cards/{card}/comments', [ApiCommentController::class, 'storeOnCard']);           // Make comment on a card.
    Route::put('comments/{comment}', [ApiCommentController::class, 'update']);              // Update comment.
    Route::delete('comments/{comment}', [ApiCommentController::class, 'destroy']);          // Delete comment.
});
Route::group(['middleware' => ['auth:sanctum', 'role:admin']], function () {
    Route::get('comments', [ApiCommentController::class, 'index']);    // Show comment by ID.
});

// RATINGS
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('ratings/{rating}', [ApiRatingController::class, 'show']);               // Show rating by ID.
    Route::get('profile/ratings', [ApiRatingController::class, 'showOwn']);             // Show ratings of authenticated user.
    Route::get('planets/{planet}/rating', [ApiRatingController::class, 'showAvgOfPlanet']);       // Show average rating of a planet.
    Route::post('planets/{planet}/ratings', [ApiRatingController::class, 'store']);     // Make rating on a planet.
    Route::put('ratings/{rating}', [ApiRatingController::class, 'update']);             // Update rating.
    Route::delete('ratings/{rating}', [ApiRatingController::class, 'destroy']);         // Delete rating.
});
Route::group(['middleware' => ['auth:sanctum', 'role:admin']], function () {
    Route::get('ratings', [ApiRatingController::class, 'index']);              // Show rating by ID.
    Route::get('planets/{planet}/ratings', [ApiRatingController::class, 'showByPlanet']);   // Show ratings made on a planet.
    Route::get('users/{user}/ratings', [ApiRatingController::class, 'showByUser']);         // Show ratings made by another user.
});

// CARDS
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('cards', [CardController::class, 'index']);
    Route::get('cards/{card}', [CardController::class, 'show']);
});
Route::group(['middleware' => ['auth:sanctum', 'role:loader,admin']], function () {
    Route::post('cards', [CardController::class, 'store']);
    Route::put('cards/{card}', [CardController::class, 'update']);
    Route::patch('cards/{card}', [CardController::class, 'restock']);
    Route::delete('cards/{card}', [CardController::class, 'destroy']);
});

// PURCHASES
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('purchases/items', [PurchaseController::class, 'showItems']);
    Route::post('purchases/add/card/{card}', [PurchaseController::class, 'addCard']);
    Route::delete('purchases/items/{item}', [PurchaseController::class, 'removeItem']);
    Route::post('purchases/confirm', [PurchaseController::class, 'confirm']);
});
Route::group(['middleware' => ['auth:sanctum', 'role:admin']], function () {
    Route::get('users/{user}/purchases', [PurchaseController::class, 'showByUser']);
    Route::get('purchases/{purchase}/items', [PurchaseController::class, 'showItems']);
    Route::delete('purchases/{purchase}', [PurchaseController::class, 'destroy']);
});

