<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAlumnoRequest extends FormRequest
{
    /**
     * ¿Puede el usuario hacer esta petición? En el Bloque 8 se revisa con tokens.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas para registrar un alumno.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'numero_control' => ['required', 'digits:8', 'unique:alumnos,numero_control'],
            'nombre' => ['required', 'string', 'min:3', 'max:120'],
            'correo' => ['required', 'email', 'max:255', 'unique:alumnos,correo'],
            'carrera' => ['required', 'string', 'max:80'],
            'semestre' => ['required', 'integer', 'between:1,12'],
        ];
    }

    /**
     * Mensajes personalizados en español.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'numero_control.digits' => 'El número de control debe tener 8 dígitos.',
            'numero_control.unique' => 'Ya existe un alumno con ese número de control.',
            'correo.email' => 'Escribe un correo válido.',
            'correo.unique' => 'Ese correo ya está registrado.',
            'semestre.between' => 'El semestre debe estar entre 1 y 12.',
        ];
    }

    /**
     * Nombres legibles de los campos.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'numero_control' => 'número de control',
        ];
    }
}
