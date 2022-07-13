<?php

//use App\Http\Controllers\API\V1\ComputerController;
use API\V1\ComputerController;
use App\Http\Controllers\API\V1\AuthController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('v1')->group(function () {
    Route::post('login', [AuthController::class, 'signin']);
    Route::get('login', [AuthController::class, 'signin']);
    Route::post('register', [AuthController::class, 'signup']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('v1')->group(function () {
        Route::apiResource('computers', ComputerController::class);
    });
});

