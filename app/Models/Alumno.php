<?php

namespace App\Models;

use Database\Factories\AlumnoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    /** @use HasFactory<AlumnoFactory> */
    use HasFactory;

    /**
     * Campos que se pueden llenar con create() y update().
     *
     * @var list<string>
     */
    protected $fillable = [
        'numero_control',
        'nombre',
        'correo',
        'carrera',
        'semestre',
    ];

    /**
     * Conversión de tipos al leer de la base de datos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'semestre' => 'integer',
        ];
    }
}
