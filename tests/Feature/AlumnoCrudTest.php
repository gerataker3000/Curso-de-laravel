<?php

namespace Tests\Feature;

use App\Models\Alumno;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AlumnoCrudTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return array<string, mixed>
     */
    private function datosValidos(array $cambios = []): array
    {
        return [
            'numero_control' => '21519999',
            'nombre' => 'Laura Gómez',
            'correo' => 'laura@example.com',
            'carrera' => 'Industrial',
            'semestre' => 4,
            ...$cambios,
        ];
    }

    public function test_muestra_el_formulario_de_alta(): void
    {
        $this->get(route('alumnos.create'))->assertOk()->assertSee('Nuevo alumno');
    }

    public function test_registra_un_alumno(): void
    {
        $respuesta = $this->post(route('alumnos.store'), $this->datosValidos());

        $alumno = Alumno::firstWhere('numero_control', '21519999');
        $respuesta->assertRedirect(route('alumnos.show', $alumno))->assertSessionHas('exito');
        $this->assertDatabaseHas('alumnos', ['correo' => 'laura@example.com']);
    }

    public function test_valida_campos_obligatorios(): void
    {
        $this->post(route('alumnos.store'), [])
            ->assertSessionHasErrors(['numero_control', 'nombre', 'correo', 'carrera', 'semestre']);

        $this->assertDatabaseCount('alumnos', 0);
    }

    public function test_valida_formato_y_mensajes_en_espanol(): void
    {
        $this->post(route('alumnos.store'), $this->datosValidos(['numero_control' => '123', 'semestre' => 15]))
            ->assertSessionHasErrors([
                'numero_control' => 'El número de control debe tener 8 dígitos.',
                'semestre' => 'El semestre debe estar entre 1 y 12.',
            ]);
    }

    public function test_no_permite_numero_de_control_repetido(): void
    {
        Alumno::factory()->create(['numero_control' => '21519999']);

        $this->post(route('alumnos.store'), $this->datosValidos())
            ->assertSessionHasErrors(['numero_control' => 'Ya existe un alumno con ese número de control.']);
    }

    public function test_actualiza_un_alumno_conservando_su_correo(): void
    {
        $alumno = Alumno::factory()->create(['correo' => 'mismo@example.com']);

        $this->put(route('alumnos.update', $alumno), $this->datosValidos(['correo' => 'mismo@example.com', 'semestre' => 6]))
            ->assertRedirect(route('alumnos.show', $alumno))
            ->assertSessionHasNoErrors();

        $this->assertSame(6, $alumno->fresh()->semestre);
    }

    public function test_elimina_un_alumno(): void
    {
        $alumno = Alumno::factory()->create();

        $this->delete(route('alumnos.destroy', $alumno))->assertRedirect(route('alumnos.index'));

        $this->assertModelMissing($alumno);
    }
}
