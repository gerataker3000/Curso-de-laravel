<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

class UpdateAlumnoRequest extends StoreAlumnoRequest
{
    /**
     * Mismas reglas que al registrar, pero el unique ignora al propio alumno.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $alumno = $this->route('alumno');

        return [
            ...parent::rules(),
            'numero_control' => ['required', 'digits:8', Rule::unique('alumnos', 'numero_control')->ignore($alumno)],
            'correo' => ['required', 'email', 'max:255', Rule::unique('alumnos', 'correo')->ignore($alumno)],
        ];
    }
}
