@extends('layouts.app')

@section('titulo', 'Nuevo alumno')

@section('contenido')
    <h1 class="h3 mb-3">Nuevo alumno</h1>

    <form action="{{ route('alumnos.store') }}" method="POST" class="card card-body">
        @include('alumnos._form')
    </form>
@endsection
