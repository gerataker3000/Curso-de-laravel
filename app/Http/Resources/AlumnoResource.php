<?php

namespace App\Http\Resources;

use App\Models\Alumno;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Define el JSON que ve el cliente de la API: qué campos, con qué nombre y formato.
 *
 * @mixin Alumno
 */
class AlumnoResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'numero_control' => $this->numero_control,
            'nombre' => $this->nombre,
            'correo' => $this->correo,
            'carrera' => $this->carrera,
            'semestre' => $this->semestre,
            'por_egresar' => $this->semestre >= 9,
            'registrado' => $this->created_at?->format('Y-m-d H:i'),
            'enlaces' => [
                'self' => route('api.alumnos.show', $this->id),
            ],
        ];
    }
}
