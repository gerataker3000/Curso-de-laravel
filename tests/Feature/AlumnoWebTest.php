<?php

namespace Tests\Feature;

use App\Models\Alumno;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AlumnoWebTest extends TestCase
{
    use RefreshDatabase;

    public function test_la_raiz_redirige_a_la_lista_de_alumnos(): void
    {
        $this->get('/')->assertRedirect(route('alumnos.index'));
    }

    public function test_muestra_la_lista_de_alumnos(): void
    {
        $alumno = Alumno::factory()->create(['nombre' => 'Ana López']);

        $this->get(route('alumnos.index'))
            ->assertOk()
            ->assertViewIs('alumnos.index')
            ->assertSee($alumno->nombre)
            ->assertSee($alumno->correo);
    }

    public function test_la_lista_se_pagina_de_10_en_10(): void
    {
        Alumno::factory()->count(15)->create();

        $this->get(route('alumnos.index'))
            ->assertViewHas('alumnos', fn ($alumnos) => $alumnos->count() === 10 && $alumnos->total() === 15);
    }

    public function test_muestra_el_detalle_de_un_alumno(): void
    {
        $alumno = Alumno::factory()->create();

        $this->get(route('alumnos.show', $alumno))
            ->assertOk()
            ->assertSee($alumno->nombre);
    }

    public function test_alumno_inexistente_regresa_404(): void
    {
        $this->get(route('alumnos.show', 999))->assertNotFound();
    }
}
