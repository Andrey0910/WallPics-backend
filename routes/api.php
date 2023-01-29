<?php

use App\Http\Controllers\Api\v1\PhotosController;
use App\Http\Controllers\Api\v1\SetPhotosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::get('/photos', [PhotosController::class, 'index']);

Route::apiResources([
    '/photos' => PhotosController::class,
    '/set_photos' => SetPhotosController::class
    ]);
