<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\PenaltyController;
use App\Http\Controllers\RentController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('a24')->group(function () {
    Route::post('/auth/login', [AuthController::class, 'login']);

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/auth/logout', [AuthController::class, 'logout']);

        // register
        Route::get('/register', [UserController::class, 'index']);
        Route::get('/register/{id}', [UserController::class, 'show']);
        Route::post('/register', [UserController::class, 'register']);
        Route::put('/register/{id}', [UserController::class, 'update']);
        Route::delete('/register/{id}', [UserController::class, 'destroy']);

        Route::resource('car', CarController::class);
        Route::resource('rent', RentController::class);
        Route::resource('return', ReturnController::class);
        Route::resource('penalty', PenaltyController::class);
    });
});
