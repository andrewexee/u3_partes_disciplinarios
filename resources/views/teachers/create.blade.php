@extends('layouts.app')
@section('title', 'Nuevo profesor')

@section('content')
<div class="page-header">
    <div>
        <h1>Nuevo profesor</h1>
        <div class="breadcrumb"><a href="{{ route('teachers.index') }}">Profesores</a> / Crear</div>
    </div>
</div>

<div class="card" style="max-width:640px">
    <div class="card-header"><h2>Datos del profesor</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ route('teachers.store') }}">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                           value="{{ old('nombre') }}" required>
                    @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Apellidos</label>
                    <input type="text" name="apellidos" class="form-control @error('apellidos') is-invalid @enderror"
                           value="{{ old('apellidos') }}" required>
                    @error('apellidos')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="form-group">
                <label>Especialidad</label>
                <input type="text" name="especialidad" class="form-control"
                       value="{{ old('especialidad') }}" placeholder="Opcional">
            </div>
            <div class="form-group">
                <label>Usuario de acceso</label>
                <select name="user_id" class="form-control @error('user_id') is-invalid @enderror" required>
                    <option value="">— Selecciona un usuario —</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                @error('user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div style="display:flex;gap:.75rem;margin-top:.5rem">
                <button type="submit" class="btn btn-primary">Guardar profesor</button>
                <a href="{{ route('teachers.index') }}" class="btn btn-outline">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection