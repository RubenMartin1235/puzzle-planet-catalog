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



Route::post('register', [ApiUserController::class, 'register']);
Route::post('login', [ApiUserController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('profile', [ApiUserController::class, 'profile']);
    Route::get('logout', [ApiUserController::class, 'logout']);
    Route::put('profile/update', [ApiUserController::class, 'profileUpdate']);
    Route::delete('profile/delete', [ApiUserController::class, 'profileDelete']);

    Route::get('users/{user}', [ApiUserController::class, 'show']);
});
Route::group(['middleware' => ['auth:sanctum', 'role:admin']], function () {
    Route::post('users', [ApiUserController::class, 'store']);
    Route::put('users/{user}', [ApiUserController::class, 'update']);
    Route::delete('users/{user}', [ApiUserController::class, 'destroy']);
});
Route::get('users/{user}', [ApiUserController::class, 'show']);
/*
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::get('planets', [ApiPlanetController::class, 'index']);
Route::get('planets/{planet}', [ApiPlanetController::class, 'show']);
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('planets', [ApiPlanetController::class, 'store']);
    Route::put('planets/{planet}', [ApiPlanetController::class, 'update']);
    Route::delete('planets/{planet}', [ApiPlanetController::class, 'destroy']);
});
//Route::apiResource('planets', ApiPlanetController::class)->middleware('auth:sanctum');
Route::apiResource('blocks', ApiBlockController::class)->middleware('auth:sanctum');
Route::apiResource('comments', ApiCommentController::class)->middleware('auth:sanctum');
Route::apiResource('ratings', ApiRatingController::class)->middleware('auth:sanctum');

