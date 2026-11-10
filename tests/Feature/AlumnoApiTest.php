<?php

namespace Tests\Feature;

use App\Models\Alumno;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AlumnoApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Desde el Bloque 8 la API exige token: simulamos uno con todos los permisos.
     */
    protected function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs(User::factory()->create(), ['alumnos:leer', 'alumnos:escribir']);
    }

    public function test_lista_alumnos_paginados_con_resource(): void
    {
        Alumno::factory()->count(12)->create();

        $this->getJson('/api/alumnos')
            ->assertOk()
            ->assertJsonCount(10, 'data')
            ->assertJsonStructure([
                'data' => [['id', 'numero_control', 'nombre', 'correo', 'carrera', 'semestre', 'por_egresar', 'registrado', 'enlaces' => ['self']]],
                'links',
                'meta' => ['current_page', 'total'],
            ])
            ->assertJsonPath('meta.total', 12);
    }

    public function test_muestra_un_alumno(): void
    {
        $alumno = Alumno::factory()->create(['semestre' => 9]);

        $this->getJson("/api/alumnos/{$alumno->id}")
            ->assertOk()
            ->assertJsonPath('data.nombre', $alumno->nombre)
            ->assertJsonPath('data.por_egresar', true);
    }

    public function test_alumno_inexistente_regresa_404_en_json(): void
    {
        $this->getJson('/api/alumnos/999')->assertNotFound()->assertJsonStructure(['message']);
    }

    public function test_crea_un_alumno_y_regresa_201(): void
    {
        $this->postJson('/api/alumnos', [
            'numero_control' => '21510099',
            'nombre' => 'Pedro Ruiz',
            'correo' => 'pedro@example.com',
            'carrera' => 'Electrónica',
            'semestre' => 1,
        ])->assertCreated()->assertJsonPath('data.numero_control', '21510099');

        $this->assertDatabaseHas('alumnos', ['correo' => 'pedro@example.com']);
    }

    public function test_errores_de_validacion_regresan_422(): void
    {
        $this->postJson('/api/alumnos', ['numero_control' => '1'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['numero_control', 'nombre', 'correo', 'carrera', 'semestre']);
    }

    public function test_actualiza_un_alumno(): void
    {
        $alumno = Alumno::factory()->create();

        $this->putJson("/api/alumnos/{$alumno->id}", [...$alumno->only(['numero_control', 'nombre', 'correo', 'carrera']), 'semestre' => 8])
            ->assertOk()
            ->assertJsonPath('data.semestre', 8);
    }

    public function test_elimina_un_alumno_y_regresa_204(): void
    {
        $alumno = Alumno::factory()->create();

        $this->deleteJson("/api/alumnos/{$alumno->id}")->assertNoContent();

        $this->assertModelMissing($alumno);
    }
}
