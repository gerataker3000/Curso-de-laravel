<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\View\View;

class AlumnoController extends Controller
{
    /**
     * Lista paginada de alumnos (GET /alumnos).
     */
    public function index(): View
    {
        $alumnos = Alumno::query()->orderBy('nombre')->paginate(10);

        return view('alumnos.index', compact('alumnos'));
    }

    /**
     * Detalle de un alumno (GET /alumnos/{alumno}).
     * Route Model Binding: Laravel busca el Alumno por id o responde 404.
     */
    public function show(Alumno $alumno): View
    {
        return view('alumnos.show', compact('alumno'));
    }
}
