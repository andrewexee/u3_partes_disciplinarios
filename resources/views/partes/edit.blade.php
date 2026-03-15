@extends('layouts.app')
@section('title', 'Editar parte')

@section('content')
<div class="page-header">
    <div>
        <h1>Editar parte</h1>
        <div class="breadcrumb"><a href="{{ route('partes.index') }}">Partes</a> / Editar</div>
    </div>
</div>

<div class="card" style="max-width:680px">
    <div class="card-header"><h2>Datos del parte</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ route('partes.update', $parte) }}">
            @csrf @method('PUT')

            {{-- Selector de profesor: solo visible para admin --}}
            @if($esAdmin)
                <div class="form-group">
                    <label>Profesor que emite el parte</label>
                    <select name="teacher_id"
                            class="form-control @error('teacher_id') is-invalid @enderror"
                            required>
                        <option value="">— Selecciona un profesor —</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}"
                                {{ old('teacher_id', $parte->teacher_id) == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->nombre_completo }} ({{ $teacher->especialidad ?? 'Sin especialidad' }})
                            </option>
                        @endforeach
                    </select>
                    @error('teacher_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            @endif

            <div class="form-group">
                <label>Alumno apercibido</label>
                <select name="alumno_id"
                        class="form-control @error('alumno_id') is-invalid @enderror"
                        required>
                    <option value="">— Selecciona un alumno —</option>
                    @foreach($alumnos as $alumno)
                        <option value="{{ $alumno->id }}"
                            {{ old('alumno_id', $parte->alumno_id) == $alumno->id ? 'selected' : '' }}>
                            {{ $alumno->nombre_completo }} — {{ $alumno->grupo }} ({{ $alumno->curso }})
                        </option>
                    @endforeach
                </select>
                @error('alumno_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Fecha del parte</label>
                    <input type="date" name="fecha"
                           class="form-control @error('fecha') is-invalid @enderror"
                           value="{{ old('fecha', $parte->fecha->format('Y-m-d')) }}"
                           required>
                    @error('fecha')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Gravedad</label>
                    <select name="tipo" class="form-control" required>
                        <option value="leve"      {{ old('tipo', $parte->tipo) == 'leve'      ? 'selected' : '' }}>Leve</option>
                        <option value="grave"     {{ old('tipo', $parte->tipo) == 'grave'     ? 'selected' : '' }}>Grave</option>
                        <option value="muy_grave" {{ old('tipo', $parte->tipo) == 'muy_grave' ? 'selected' : '' }}>Muy grave</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Descripción de los hechos</label>
                <textarea name="descripcion"
                          class="form-control @error('descripcion') is-invalid @enderror"
                          required maxlength="1000" rows="5">{{ old('descripcion', $parte->descripcion) }}</textarea>
                @error('descripcion')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div style="display:flex;gap:.75rem;margin-top:.5rem">
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                <a href="{{ route('partes.show', $parte) }}" class="btn btn-outline">Cancelar</a>
            </div>

        </form>
    </div>
</div>
@endsection