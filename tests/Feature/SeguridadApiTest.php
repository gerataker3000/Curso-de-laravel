<?php

namespace Tests\Feature;

use App\Models\Alumno;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SeguridadApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_sin_token_regresa_401(): void
    {
        $this->getJson('/api/alumnos')->assertUnauthorized();
    }

    public function test_token_invalido_regresa_401(): void
    {
        $this->withToken('token-inventado')->getJson('/api/alumnos')->assertUnauthorized();
    }

    public function test_login_correcto_entrega_un_token_que_sirve(): void
    {
        $user = User::factory()->create(['password' => 'secreto123']);

        $token = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'secreto123',
            'nombre_dispositivo' => 'postman',
        ])->assertCreated()
            ->assertJsonPath('tipo', 'Bearer')
            ->assertJsonPath('permisos', ['alumnos:leer', 'alumnos:escribir'])
            ->json('token');

        $this->withToken($token)->getJson('/api/yo')->assertOk()->assertJsonPath('email', $user->email);
    }

    public function test_login_incorrecto_no_revela_si_existe_el_correo(): void
    {
        $user = User::factory()->create();

        $this->postJson('/api/login', ['email' => $user->email, 'password' => 'mala', 'nombre_dispositivo' => 'x'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['email' => 'Las credenciales no son correctas.']);

        $this->postJson('/api/login', ['email' => 'nadie@example.com', 'password' => 'mala', 'nombre_dispositivo' => 'x'])
            ->assertJsonValidationErrors(['email' => 'Las credenciales no son correctas.']);
    }

    public function test_token_de_solo_lectura_no_puede_escribir_403(): void
    {
        Sanctum::actingAs(User::factory()->create(), ['alumnos:leer']);
        $alumno = Alumno::factory()->create();

        $this->getJson('/api/alumnos')->assertOk();
        $this->deleteJson("/api/alumnos/{$alumno->id}")->assertForbidden();
        $this->assertModelExists($alumno);
    }

    public function test_logout_revoca_el_token(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('postman', ['alumnos:leer'])->plainTextToken;

        $this->withToken($token)->postJson('/api/logout')->assertNoContent();

        $this->assertDatabaseCount('personal_access_tokens', 0);
    }

    public function test_login_bloquea_despues_de_5_intentos_429(): void
    {
        $datos = ['email' => 'ataque@example.com', 'password' => 'x', 'nombre_dispositivo' => 'bot'];

        for ($intento = 1; $intento <= 5; $intento++) {
            $this->postJson('/api/login', $datos)->assertUnprocessable();
        }

        $this->postJson('/api/login', $datos)->assertTooManyRequests();
    }
}
