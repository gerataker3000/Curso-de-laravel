@extends('layouts.app')

@section('titulo', 'Lista de alumnos')

@section('contenido')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Alumnos</h1>
        <a href="{{ route('alumnos.create') }}" class="btn btn-primary">Nuevo alumno</a>
    </div>

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
                    <td class="text-nowrap">
                        <a href="{{ route('alumnos.show', $alumno) }}" class="btn btn-sm btn-outline-primary">Ver</a>
                        <a href="{{ route('alumnos.edit', $alumno) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">No hay alumnos registrados.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $alumnos->links() }}
@endsection
