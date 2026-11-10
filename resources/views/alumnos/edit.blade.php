@extends('layouts.app')

@section('titulo', 'Editar alumno')

@section('contenido')
    <h1 class="h3 mb-3">Editar: {{ $alumno->nombre }}</h1>

    <form action="{{ route('alumnos.update', $alumno) }}" method="POST" class="card card-body">
        @method('PUT')
        @include('alumnos._form')
    </form>
@endsection
