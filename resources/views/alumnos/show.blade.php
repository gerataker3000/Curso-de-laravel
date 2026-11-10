@extends('layouts.app')

@section('titulo', $alumno['nombre'])

@section('contenido')
    <div class="card">
        <div class="card-body">
            <h1 class="h4">{{ $alumno['nombre'] }}</h1>
            <p class="mb-1"><strong>No. control:</strong> {{ $alumno['numero_control'] }}</p>
            <p class="mb-1"><strong>Carrera:</strong> {{ $alumno['carrera'] }}</p>
            <p><strong>Semestre:</strong> {{ $alumno['semestre'] }}</p>
            <a href="{{ route('alumnos.index') }}" class="btn btn-secondary">Regresar</a>
        </div>
    </div>
@endsection
