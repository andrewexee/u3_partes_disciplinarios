@extends('layouts.app')
@section('title', 'Nuevo profesor')

@section('content')
<div class="page-header">
    <div>
        <h1>Nuevo profesor</h1>
        <div class="breadcrumb"><a href="{{ route('teachers.index') }}">Profesores</a> / Crear</div>
    </div>
</div>

<div class="card" style="max-width:680px">
    <div class="card-header"><h2>Datos del profesor</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ route('teachers.store') }}">
            @csrf

            {{-- ── SECCIÓN: CREDENCIALES DE ACCESO ── --}}
            <p style="font-size:.75rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;
                      color:var(--navy);border-bottom:2px solid var(--accent);padding-bottom:.4rem;
                      margin-bottom:1.25rem">
                Credenciales de acceso
            </p>

            <div class="form-group">
                <label>Nombre de usuario</label>
                <input type="text" name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}"
                       placeholder="Nombre visible en el sistema"
                       required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label>Email de acceso</label>
                <input type="email" name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email') }}"
                       placeholder="correo@ies.es"
                       required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Contraseña</label>
                    <input type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Mínimo 8 caracteres"
                           required>
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Repetir contraseña</label>
                    <input type="password" name="password_confirmation"
                           class="form-control"
                           placeholder="Repite la contraseña"
                           required>
                </div>
            </div>

            {{-- ── SECCIÓN: DATOS DEL PROFESOR ── --}}
            <p style="font-size:.75rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;
                      color:var(--navy);border-bottom:2px solid var(--accent);padding-bottom:.4rem;
                      margin-bottom:1.25rem;margin-top:1.75rem">
                Datos del profesor
            </p>

            <div class="form-row">
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" name="nombre"
                           class="form-control @error('nombre') is-invalid @enderror"
                           value="{{ old('nombre') }}"
                           required>
                    @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Apellidos</label>
                    <input type="text" name="apellidos"
                           class="form-control @error('apellidos') is-invalid @enderror"
                           value="{{ old('apellidos') }}"
                           required>
                    @error('apellidos')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-group">
                <label>Especialidad</label>
                <input type="text" name="especialidad"
                       class="form-control"
                       value="{{ old('especialidad') }}"
                       placeholder="Opcional — ej: Matemáticas, Lengua…">
            </div>

            <div style="display:flex;gap:.75rem;margin-top:.5rem">
                <button type="submit" class="btn btn-primary">Crear profesor</button>
                <a href="{{ route('teachers.index') }}" class="btn btn-outline">Cancelar</a>
            </div>

        </form>
    </div>
</div>
@endsection