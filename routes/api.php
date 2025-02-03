<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\RentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/a24/auth/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/a24/auth/logout', [AuthController::class, 'logout']);

    // register
    Route::get('/a24/register', [AuthController::class, 'index']);
    Route::post('/a24/register', [AuthController::class, 'register']);
    Route::put('/a24/register/{id}', [AuthController::class, 'update']);
    Route::delete('/a24/register/{id}', [AuthController::class, 'destroy']);

    Route::resource('car', CarController::class);
    Route::resource('rent', RentController::class);
});
