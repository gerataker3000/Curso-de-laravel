@extends('layouts.app')

@section('titulo', $alumno->nombre)

@section('contenido')
    <div class="card">
        <div class="card-body">
            <h1 class="h4">{{ $alumno->nombre }}</h1>
            <p class="mb-1"><strong>No. control:</strong> {{ $alumno->numero_control }}</p>
            <p class="mb-1"><strong>Correo:</strong> {{ $alumno->correo }}</p>
            <p class="mb-1"><strong>Carrera:</strong> {{ $alumno->carrera }}</p>
            <p><strong>Semestre:</strong> {{ $alumno->semestre }}</p>
            <div class="d-flex gap-2">
                <a href="{{ route('alumnos.index') }}" class="btn btn-secondary">Regresar</a>
                <a href="{{ route('alumnos.edit', $alumno) }}" class="btn btn-primary">Editar</a>

                <form action="{{ route('alumnos.destroy', $alumno) }}" method="POST"
                      onsubmit="return confirm('¿Eliminar este alumno?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
@endsection
