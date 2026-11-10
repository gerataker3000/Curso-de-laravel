<?php

use App\Http\Controllers\AlumnoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('alumnos.index');
});

// Bloque 3: solo lectura (index y show). En el Bloque 5 se quita ->only().
Route::resource('alumnos', AlumnoController::class)->only(['index', 'show']);
