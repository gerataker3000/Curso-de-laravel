@extends('layouts.app')

@section('titulo', 'Lista de alumnos')

@section('contenido')
    <h1 class="h3 mb-3">Alumnos</h1>

    <table class="table table-striped bg-white">
        <thead>
            <tr>
                <th>No. control</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Carrera</th>
                <th>Semestre</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($alumnos as $alumno)
                <tr>
                    <td>{{ $alumno->numero_control }}</td>
                    <td>{{ $alumno->nombre }}</td>
                    <td>{{ $alumno->correo }}</td>
                    <td>{{ $alumno->carrera }}</td>
                    <td>{{ $alumno->semestre }}</td>
                    <td><a href="{{ route('alumnos.show', $alumno) }}" class="btn btn-sm btn-outline-primary">Ver</a></td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">No hay alumnos registrados.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $alumnos->links() }}
@endsection
