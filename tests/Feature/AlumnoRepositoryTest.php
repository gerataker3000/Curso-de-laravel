<?php

namespace Tests\Feature;

use App\Models\Alumno;
use App\Repositories\AlumnoRepository;
use App\Repositories\AlumnoRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Mockery\MockInterface;
use Tests\TestCase;

class AlumnoRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_el_contenedor_entrega_la_implementacion_eloquent(): void
    {
        $this->assertInstanceOf(AlumnoRepository::class, app(AlumnoRepositoryInterface::class));
    }

    public function test_pagina_ordenado_por_nombre(): void
    {
        Alumno::factory()->create(['nombre' => 'Zoe']);
        Alumno::factory()->create(['nombre' => 'Ana']);

        $pagina = app(AlumnoRepositoryInterface::class)->paginar(1);

        $this->assertSame('Ana', $pagina->first()->nombre);
        $this->assertSame(2, $pagina->total());
    }

    public function test_crea_actualiza_y_elimina(): void
    {
        $repositorio = app(AlumnoRepositoryInterface::class);

        $alumno = $repositorio->crear(Alumno::factory()->raw(['semestre' => 2]));
        $repositorio->actualizar($alumno, ['semestre' => 3]);
        $this->assertSame(3, $alumno->fresh()->semestre);

        $repositorio->eliminar($alumno);
        $this->assertModelMissing($alumno);
    }

    public function test_el_controlador_usa_el_repositorio_y_se_puede_simular(): void
    {
        $this->mock(AlumnoRepositoryInterface::class, function (MockInterface $mock): void {
            $mock->shouldReceive('paginar')->once()->andReturn(
                new LengthAwarePaginator([Alumno::factory()->make(['id' => 1, 'nombre' => 'Alumno simulado'])], 1, 10)
            );
        });

        $this->get(route('alumnos.index'))->assertOk()->assertSee('Alumno simulado');
    }
}
