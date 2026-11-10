<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAlumnoRequest;
use App\Http\Requests\UpdateAlumnoRequest;
use App\Models\Alumno;
use App\Repositories\AlumnoRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AlumnoController extends Controller
{
    /**
     * Laravel inyecta el repositorio registrado en AppServiceProvider.
     */
    public function __construct(private AlumnoRepositoryInterface $alumnos) {}

    /**
     * Lista paginada de alumnos (GET /alumnos).
     */
    public function index(): View
    {
        $alumnos = $this->alumnos->paginar();

        return view('alumnos.index', compact('alumnos'));
    }

    /**
     * Formulario de alta (GET /alumnos/create).
     */
    public function create(): View
    {
        return view('alumnos.create', ['alumno' => new Alumno]);
    }

    /**
     * Guarda un alumno nuevo (POST /alumnos).
     * Si la validación falla, Laravel regresa al formulario con los errores.
     */
    public function store(StoreAlumnoRequest $request): RedirectResponse
    {
        $alumno = $this->alumnos->crear($request->validated());

        return redirect()->route('alumnos.show', $alumno)
            ->with('exito', 'Alumno registrado correctamente.');
    }

    /**
     * Detalle de un alumno (GET /alumnos/{alumno}).
     */
    public function show(Alumno $alumno): View
    {
        return view('alumnos.show', compact('alumno'));
    }

    /**
     * Formulario de edición (GET /alumnos/{alumno}/edit).
     */
    public function edit(Alumno $alumno): View
    {
        return view('alumnos.edit', compact('alumno'));
    }

    /**
     * Actualiza un alumno (PUT /alumnos/{alumno}).
     */
    public function update(UpdateAlumnoRequest $request, Alumno $alumno): RedirectResponse
    {
        $this->alumnos->actualizar($alumno, $request->validated());

        return redirect()->route('alumnos.show', $alumno)
            ->with('exito', 'Alumno actualizado correctamente.');
    }

    /**
     * Elimina un alumno (DELETE /alumnos/{alumno}).
     */
    public function destroy(Alumno $alumno): RedirectResponse
    {
        $this->alumnos->eliminar($alumno);

        return redirect()->route('alumnos.index')
            ->with('exito', 'Alumno eliminado.');
    }
}
