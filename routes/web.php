<?php

use App\Http\Controllers\AlumnoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('alumnos.index');
});

// Bloque 5: CRUD completo (7 rutas).
Route::resource('alumnos', AlumnoController::class);
