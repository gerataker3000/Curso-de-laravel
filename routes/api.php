<?php

use App\Http\Controllers\Api\AlumnoController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

// Pública, pero limitada a 5 intentos por minuto (anti fuerza bruta).
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:login');

// Todo lo demás exige token Bearer válido (auth:sanctum) y 60 peticiones por minuto.
Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
    Route::get('/yo', [AuthController::class, 'yo']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Leer: basta con el permiso alumnos:leer.
    Route::apiResource('alumnos', AlumnoController::class)
        ->only(['index', 'show'])
        ->names('api.alumnos')
        ->middleware('abilities:alumnos:leer');

    // Escribir: requiere alumnos:escribir.
    Route::apiResource('alumnos', AlumnoController::class)
        ->only(['store', 'update', 'destroy'])
        ->names('api.alumnos')
        ->middleware('abilities:alumnos:escribir');
});
