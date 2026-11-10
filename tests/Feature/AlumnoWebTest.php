<?php

namespace Tests\Feature;

use Tests\TestCase;

class AlumnoWebTest extends TestCase
{
    public function test_la_raiz_redirige_a_la_lista_de_alumnos(): void
    {
        $this->get('/')->assertRedirect(route('alumnos.index'));
    }

    public function test_muestra_la_lista_de_alumnos(): void
    {
        $this->get(route('alumnos.index'))
            ->assertOk()
            ->assertViewIs('alumnos.index')
            ->assertSee('Ana López');
    }

    public function test_muestra_el_detalle_de_un_alumno(): void
    {
        $this->get(route('alumnos.show', 2))
            ->assertOk()
            ->assertSee('Carlos Pérez');
    }

    public function test_alumno_inexistente_regresa_404(): void
    {
        $this->get(route('alumnos.show', 99))->assertNotFound();
    }
}
