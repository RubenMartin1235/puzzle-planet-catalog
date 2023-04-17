<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::apiResource('planets', ApiPlanetController::class)->middleware('auth:sanctum');
Route::apiResource('blocks', ApiBlockController::class)->middleware('auth:sanctum');
Route::apiResource('comments', ApiCommentController::class)->middleware('auth:sanctum');
Route::apiResource('ratings', ApiRatingController::class)->middleware('auth:sanctum');

