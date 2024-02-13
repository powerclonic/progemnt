<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('/auth')->group(function () {
    Route::post('/', [AuthController::class, 'store']);
    Route::delete('/', [AuthController::class, 'destroy'])->middleware('auth:sanctum');
});

Route::prefix('/user')->group(function () {
    Route::post('/', [UserController::class, 'store']);

    Route::get('/', [UserController::class, 'show'])->middleware('auth:sanctum');
    Route::put('/', [UserController::class, 'update'])->middleware('auth:sanctum');
    Route::delete('/', [UserController::class, 'destroy'])->middleware('auth:sanctum');
});

Route::apiResource('projects', ProjectController::class, ['middleware' => ['auth:sanctum']]);
