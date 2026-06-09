<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PendudukController;
use App\Http\Controllers\Api\KeluargaController;

Route::get('/health', function () {
    return response()->json([
        'status' => 'connected',
        'message' => 'Server is running',
        'timestamp' => now()->toIso8601String()
    ]);
});

Route::match(['get', 'post'], '/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/penduduk', [PendudukController::class, 'index']);
    Route::post('/penduduk', [PendudukController::class, 'store']);
    Route::get('/penduduk/{id}', [PendudukController::class, 'show']);
    Route::put('/penduduk/{id}', [PendudukController::class, 'update']);
    Route::delete('/penduduk/{id}', [PendudukController::class, 'destroy']);

    Route::get('/keluarga', [KeluargaController::class, 'index']);
    Route::post('/keluarga', [KeluargaController::class, 'store']);
    Route::get('/keluarga/{id}', [KeluargaController::class, 'show']);
    Route::put('/keluarga/{id}', [KeluargaController::class, 'update']);
    Route::delete('/keluarga/{id}', [KeluargaController::class, 'destroy']);

    Route::post('/logout', [AuthController::class, 'logout']);
});