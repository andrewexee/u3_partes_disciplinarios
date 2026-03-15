@extends('layouts.app')
@section('title', 'Nuevo parte')

@section('content')
<div class="page-header">
    <div>
        <h1>Nuevo parte de apercibimiento</h1>
        <div class="breadcrumb"><a href="{{ route('partes.index') }}">Partes</a> / Crear</div>
    </div>
</div>

<div class="card" style="max-width:680px">
    <div class="card-header"><h2>Datos del parte</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ route('partes.store') }}">
            @csrf
            <div class="form-group">
                <label>Alumno apercibido</label>
                <select name="alumno_id" class="form-control @error('alumno_id') is-invalid @enderror" required>
                    <option value="">— Selecciona un alumno —</option>
                    @foreach($alumnos as $alumno)
                        <option value="{{ $alumno->id }}"
                            {{ old('alumno_id', $alumnoSelecto?->id) == $alumno->id ? 'selected' : '' }}>
                            {{ $alumno->nombre_completo }} — {{ $alumno->grupo }} ({{ $alumno->curso }})
                        </option>
                    @endforeach
                </select>
                @error('alumno_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Fecha del parte</label>
                    <input type="date" name="fecha" class="form-control @error('fecha') is-invalid @enderror"
                           value="{{ old('fecha', date('Y-m-d')) }}" required>
                    @error('fecha')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Gravedad</label>
                    <select name="tipo" class="form-control @error('tipo') is-invalid @enderror" required>
                        <option value="">— Selecciona —</option>
                        <option value="leve"      {{ old('tipo')=='leve'      ? 'selected':'' }}>Leve</option>
                        <option value="grave"     {{ old('tipo')=='grave'     ? 'selected':'' }}>Grave</option>
                        <option value="muy_grave" {{ old('tipo')=='muy_grave' ? 'selected':'' }}>Muy grave</option>
                    </select>
                    @error('tipo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-group">
                <label>Descripción de los hechos</label>
                <textarea name="descripcion" class="form-control @error('descripcion') is-invalid @enderror"
                          required maxlength="1000" rows="5"
                          placeholder="Describe detalladamente la conducta del alumno…">{{ old('descripcion') }}</textarea>
                @error('descripcion')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div style="display:flex;gap:.75rem;margin-top:.5rem">
                <button type="submit" class="btn btn-accent">Crear parte</button>
                <a href="{{ route('partes.index') }}" class="btn btn-outline">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection