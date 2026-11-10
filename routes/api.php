<?php

use App\Http\Controllers\Api\AlumnoController;
use Illuminate\Support\Facades\Route;

// Bloque 7: API pública (/api/alumnos). En el Bloque 8 se protege con token.
Route::apiResource('alumnos', AlumnoController::class)->names('api.alumnos');
