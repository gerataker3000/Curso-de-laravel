<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class AlumnoController extends Controller
{
    /**
     * Lista de alumnos (GET /alumnos).
     */
    public function index(): View
    {
        $alumnos = $this->alumnos();

        return view('alumnos.index', compact('alumnos'));
    }

    /**
     * Detalle de un alumno (GET /alumnos/{alumno}).
     */
    public function show(int $alumno): View
    {
        $encontrado = collect($this->alumnos())->firstWhere('id', $alumno);

        abort_if($encontrado === null, 404);

        return view('alumnos.show', ['alumno' => $encontrado]);
    }

    /**
     * Datos de ejemplo escritos a mano. En el Bloque 4 se reemplazan por el modelo Alumno.
     *
     * @return array<int, array{id: int, numero_control: string, nombre: string, carrera: string, semestre: int}>
     */
    private function alumnos(): array
    {
        return [
            ['id' => 1, 'numero_control' => '21510001', 'nombre' => 'Ana López', 'carrera' => 'Sistemas Computacionales', 'semestre' => 5],
            ['id' => 2, 'numero_control' => '21510002', 'nombre' => 'Carlos Pérez', 'carrera' => 'Industrial', 'semestre' => 3],
            ['id' => 3, 'numero_control' => '21510003', 'nombre' => 'María Hernández', 'carrera' => 'Gestión Empresarial', 'semestre' => 7],
        ];
    }
}
