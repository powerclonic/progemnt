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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user()->projects()->get();
});

Route::prefix('/auth')->group(function () {
    Route::post('/', [AuthController::class, 'store']);
    Route::delete('/', [AuthController::class, 'destroy'])->middleware('auth:sanctum');
});

Route::apiResource('projects', ProjectController::class, ['middleware' => ['auth:sanctum']]);

Route::resource('/user', UserController::class)->only('store');
