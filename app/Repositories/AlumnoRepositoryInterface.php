<?php

namespace App\Repositories;

use App\Models\Alumno;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Contrato: QUÉ se puede hacer con los alumnos, sin decir CÓMO.
 */
interface AlumnoRepositoryInterface
{
    /**
     * @return LengthAwarePaginator<int, Alumno>
     */
    public function paginar(int $porPagina = 10): LengthAwarePaginator;

    /**
     * @param  array<string, mixed>  $datos
     */
    public function crear(array $datos): Alumno;

    /**
     * @param  array<string, mixed>  $datos
     */
    public function actualizar(Alumno $alumno, array $datos): Alumno;

    public function eliminar(Alumno $alumno): void;
}
