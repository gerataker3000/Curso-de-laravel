<?php

namespace App\Repositories;

use App\Models\Alumno;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Implementación con Eloquent: aquí vive TODO el acceso a datos de alumnos.
 */
class AlumnoRepository implements AlumnoRepositoryInterface
{
    /**
     * @return LengthAwarePaginator<int, Alumno>
     */
    public function paginar(int $porPagina = 10): LengthAwarePaginator
    {
        return Alumno::query()->orderBy('nombre')->paginate($porPagina);
    }

    /**
     * @param  array<string, mixed>  $datos
     */
    public function crear(array $datos): Alumno
    {
        return Alumno::create($datos);
    }

    /**
     * @param  array<string, mixed>  $datos
     */
    public function actualizar(Alumno $alumno, array $datos): Alumno
    {
        $alumno->update($datos);

        return $alumno;
    }

    public function eliminar(Alumno $alumno): void
    {
        $alumno->delete();
    }
}
