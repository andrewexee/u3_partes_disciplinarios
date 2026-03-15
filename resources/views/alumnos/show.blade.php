@extends('layouts.app')
@section('title', $alumno->nombre_completo)

@section('content')
<div class="page-header">
    <div>
        <h1>{{ $alumno->nombre_completo }}</h1>
        <div class="breadcrumb"><a href="{{ route('alumnos.index') }}">Alumnos</a> / Detalle</div>
    </div>
    <a href="{{ route('partes.create', ['alumno_id' => $alumno->id]) }}" class="btn btn-accent">+ Abrir parte</a>
</div>

<div class="card" style="margin-bottom:1.5rem">
    <div class="card-header"><h2>Datos del alumno</h2></div>
    <div class="card-body">
        <div class="detail-grid">
            <div class="detail-item"><label>Nombre completo</label><p>{{ $alumno->nombre_completo }}</p></div>
            <div class="detail-item"><label>Grupo / Curso</label><p>{{ $alumno->grupo }} — {{ $alumno->curso }}</p></div>
            <div class="detail-item"><label>Tutor</label><p>{{ $alumno->nombre_tutor ?? '—' }}</p></div>
            <div class="detail-item"><label>Email del tutor</label><p>{{ $alumno->email_tutor }}</p></div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header"><h2>Partes de apercibimiento</h2></div>
    <div class="card-body">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr><th>Fecha</th><th>Tipo</th><th>Descripción</th><th>Profesor</th><th>Correo</th><th></th></tr>
                </thead>
                <tbody>
                @forelse($alumno->partes as $parte)
                    <tr>
                        <td>{{ $parte->fecha->format('d/m/Y') }}</td>
                        <td><span class="badge badge-{{ $parte->tipo }}">{{ $parte->tipo_label }}</span></td>
                        <td>{{ Str::limit($parte->descripcion, 60) }}</td>
                        <td>{{ $parte->teacher->nombre_completo }}</td>
                        <td>
                            @if($parte->email_enviado)
                                <span class="badge badge-enviado">Enviado</span>
                            @else
                                <span class="badge badge-pendiente">Pendiente</span>
                            @endif
                        </td>
                        <td><a href="{{ route('partes.show', $parte) }}" class="btn btn-outline btn-sm">Ver</a></td>
                    </tr>
                @empty
                    <tr><td colspan="6" style="text-align:center;color:var(--muted);padding:1.5rem">Este alumno no tiene partes.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection