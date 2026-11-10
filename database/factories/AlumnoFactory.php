<?php

namespace Database\Factories;

use App\Models\Alumno;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Alumno>
 */
class AlumnoFactory extends Factory
{
    /**
     * Datos falsos de un alumno.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'numero_control' => fake()->unique()->numerify('2151####'),
            'nombre' => fake()->name(),
            'correo' => fake()->unique()->safeEmail(),
            'carrera' => fake()->randomElement([
                'Sistemas Computacionales',
                'Industrial',
                'Gestión Empresarial',
                'Electrónica',
            ]),
            'semestre' => fake()->numberBetween(1, 9),
        ];
    }
}
