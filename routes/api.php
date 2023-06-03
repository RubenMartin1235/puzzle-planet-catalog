<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController as ApiUserController;
use App\Http\Controllers\Api\PlanetController as ApiPlanetController;
use App\Http\Controllers\Api\BlockController as ApiBlockController;
use App\Http\Controllers\Api\CommentController as ApiCommentController;
use App\Http\Controllers\Api\RatingController as ApiRatingController;
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
});

Route::group(['middleware' => ['auth:sanctum', 'role:admin']], function () {
    Route::post('users', [ApiUserController::class, 'store']);
    Route::put('users/{user}', [ApiUserController::class, 'update']);
    Route::delete('users/{user}', [ApiUserController::class, 'destroy']);
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
    Route::get('users/{user}/comments', [ApiCommentController::class, 'showByUser']);       // Show comments made by another user.

    Route::post('planets/{planet}/comments', [ApiCommentController::class, 'store']);       // Make comment on a planet.
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


