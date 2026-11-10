{{-- Formulario compartido por create y edit. --}}
@csrf

<div class="row g-3">
    <div class="col-md-4">
        <label for="numero_control" class="form-label">No. control</label>
        <input type="text" id="numero_control" name="numero_control" maxlength="8"
               value="{{ old('numero_control', $alumno->numero_control) }}"
               class="form-control @error('numero_control') is-invalid @enderror">
        @error('numero_control') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-8">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" id="nombre" name="nombre"
               value="{{ old('nombre', $alumno->nombre) }}"
               class="form-control @error('nombre') is-invalid @enderror">
        @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="correo" class="form-label">Correo</label>
        <input type="email" id="correo" name="correo"
               value="{{ old('correo', $alumno->correo) }}"
               class="form-control @error('correo') is-invalid @enderror">
        @error('correo') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
        <label for="carrera" class="form-label">Carrera</label>
        <select id="carrera" name="carrera" class="form-select @error('carrera') is-invalid @enderror">
            <option value="">Selecciona…</option>
            @foreach (['Sistemas Computacionales', 'Industrial', 'Gestión Empresarial', 'Electrónica'] as $carrera)
                <option value="{{ $carrera }}" @selected(old('carrera', $alumno->carrera) === $carrera)>{{ $carrera }}</option>
            @endforeach
        </select>
        @error('carrera') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-2">
        <label for="semestre" class="form-label">Semestre</label>
        <input type="number" id="semestre" name="semestre" min="1" max="12"
               value="{{ old('semestre', $alumno->semestre) }}"
               class="form-control @error('semestre') is-invalid @enderror">
        @error('semestre') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="mt-4">
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('alumnos.index') }}" class="btn btn-secondary">Cancelar</a>
</div>
