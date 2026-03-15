@extends('layouts.app')
@section('title', 'Parte de apercibimiento')

@section('content')
<div class="page-header">
    <div>
        <h1>Parte de apercibimiento</h1>
        <div class="breadcrumb"><a href="{{ route('partes.index') }}">Partes</a> / Detalle #{{ $parte->id }}</div>
    </div>
    <div style="display:flex;gap:.75rem">
        <a href="{{ route('partes.edit', $parte) }}" class="btn btn-outline">Editar</a>
        <form method="POST" action="{{ route('partes.destroy', $parte) }}"
              onsubmit="return confirm('¿Eliminar este parte definitivamente?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger">Eliminar</button>
        </form>
    </div>
</div>

<div class="card" style="margin-bottom:1.5rem">
    <div class="card-header">
        <h2>Información del parte</h2>
        <span class="badge badge-{{ $parte->tipo }}">{{ $parte->tipo_label }}</span>
    </div>
    <div class="card-body">
        <div class="detail-grid">
            <div class="detail-item">
                <label>Alumno apercibido</label>
                <p><a href="{{ route('alumnos.show', $parte->alumno) }}" style="color:var(--navy);font-weight:600">
                    {{ $parte->alumno->nombre_completo }}
                </a></p>
            </div>
            <div class="detail-item">
                <label>Grupo / Curso</label>
                <p>{{ $parte->alumno->grupo }} — {{ $parte->alumno->curso }}</p>
            </div>
            <div class="detail-item">
                <label>Fecha del parte</label>
                <p>{{ $parte->fecha->format('d \d\e F \d\e Y') }}</p>
            </div>
            <div class="detail-item">
                <label>Profesor responsable</label>
                <p>{{ $parte->teacher->nombre_completo }}</p>
            </div>
            <div class="detail-item detail-full">
                <label>Descripción de los hechos</label>
                <p style="line-height:1.7;white-space:pre-line">{{ $parte->descripcion }}</p>
            </div>
        </div>
    </div>
</div>

{{-- BLOQUE DE CORREO (Requisito D) --}}
<div class="card">
    <div class="card-header">
        <h2>Notificación al tutor</h2>
        @if($parte->email_enviado)
            <span class="badge badge-enviado">✓ Enviado el {{ $parte->email_enviado_at->format('d/m/Y H:i') }}</span>
        @else
            <span class="badge badge-pendiente">No enviado</span>
        @endif
    </div>
    <div class="card-body">
        {{-- Vista previa del correo --}}
        <div style="background:#f9f8f4;border:1px solid var(--border);border-radius:var(--radius);padding:1.25rem;margin-bottom:1.25rem">
            <p style="font-size:.8rem;color:var(--muted);margin-bottom:.75rem;text-transform:uppercase;letter-spacing:.06em;font-weight:600">Vista previa del correo</p>
            <p><strong>Para:</strong> {{ $parte->alumno->email_tutor }}
               @if($parte->alumno->nombre_tutor) ({{ $parte->alumno->nombre_tutor }}) @endif
            </p>
            <p><strong>Asunto:</strong> Parte de apercibimiento — {{ $parte->alumno->nombre_completo }}</p>
            <hr style="border:none;border-top:1px solid var(--border);margin:.75rem 0">
            <p>Estimado/a tutor/a,</p>
            <br>
            <p>Le comunicamos que el alumno/a <strong>{{ $parte->alumno->nombre_completo }}</strong>
               ({{ $parte->alumno->grupo }}, {{ $parte->alumno->curso }}) ha recibido un parte de apercibimiento
               de tipo <strong>{{ $parte->tipo_label }}</strong> con fecha
               <strong>{{ $parte->fecha->format('d/m/Y') }}</strong>.</p>
            <br>
            <p><strong>Motivo:</strong></p>
            <p style="white-space:pre-line;padding-left:1rem;border-left:3px solid var(--accent)">{{ $parte->descripcion }}</p>
            <br>
            <p>Emitido por: {{ $parte->teacher->nombre_completo }}</p>
            <p>IES — Sistema de Gestión de Partes</p>
        </div>

        @if(!$parte->email_enviado)
            <form method="POST" action="{{ route('partes.email', $parte) }}"
                  onsubmit="return confirm('¿Confirmas el envío del correo al tutor {{ $parte->alumno->email_tutor }}?')">
                @csrf
                <button type="submit" class="btn btn-success">
                    ✉ Enviar correo al tutor
                </button>
            </form>
        @else
            <p style="color:var(--muted);font-size:.9rem">
                El correo ya fue enviado. Si necesitas reenviarlo, edita el parte primero para registrar el nuevo envío.
            </p>
        @endif
    </div>
</div>
@endsection