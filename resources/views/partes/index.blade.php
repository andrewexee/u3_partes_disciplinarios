@extends('layouts.app')
@section('title', 'Partes de apercibimiento')

@section('content')
<div class="page-header">
    <div>
        <h1>Partes de apercibimiento</h1>
        <div class="breadcrumb">Mis partes emitidos</div>
    </div>
    <a href="{{ route('partes.create') }}" class="btn btn-accent">+ Nuevo parte</a>
</div>

<div class="card">
    <div class="card-header"><h2>Listado</h2></div>
    <div class="card-body">

        <form method="GET" action="{{ route('partes.index') }}" class="search-bar">
            <select name="tipo" class="form-control" style="max-width:180px">
                <option value="">Todos los tipos</option>
                <option value="leve"      {{ request('tipo')=='leve'      ? 'selected':'' }}>Leve</option>
                <option value="grave"     {{ request('tipo')=='grave'     ? 'selected':'' }}>Grave</option>
                <option value="muy_grave" {{ request('tipo')=='muy_grave' ? 'selected':'' }}>Muy grave</option>
            </select>
            <select name="alumno_id" class="form-control" style="max-width:220px">
                <option value="">Todos los alumnos</option>
                @foreach($alumnos as $a)
                    <option value="{{ $a->id }}" {{ request('alumno_id')==$a->id ? 'selected':'' }}>
                        {{ $a->nombre_completo }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary">Filtrar</button>
            @if(request()->hasAny(['tipo','alumno_id']))
                <a href="{{ route('partes.index') }}" class="btn btn-outline">Limpiar</a>
            @endif
        </form>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr><th>Fecha</th><th>Alumno</th><th>Tipo</th><th>Descripción</th><th>Correo</th><th></th></tr>
                </thead>
                <tbody>
                @forelse($partes as $parte)
                    <tr>
                        <td>{{ $parte->fecha->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('alumnos.show', $parte->alumno) }}" style="color:var(--navy);font-weight:500">
                                {{ $parte->alumno->nombre_completo }}
                            </a><br>
                            <small style="color:var(--muted)">{{ $parte->alumno->grupo }} · {{ $parte->alumno->curso }}</small>
                        </td>
                        <td><span class="badge badge-{{ $parte->tipo }}">{{ $parte->tipo_label }}</span></td>
                        <td>{{ Str::limit($parte->descripcion, 55) }}</td>
                        <td>
                            @if($parte->email_enviado)
                                <span class="badge badge-enviado" title="{{ $parte->email_enviado_at?->format('d/m/Y H:i') }}">✓ Enviado</span>
                            @else
                                <span class="badge badge-pendiente">Pendiente</span>
                            @endif
                        </td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('partes.show', $parte) }}" class="btn btn-outline btn-sm">Ver</a>
                                <a href="{{ route('partes.edit', $parte) }}" class="btn btn-outline btn-sm">Editar</a>
                                <form method="POST" action="{{ route('partes.destroy', $parte) }}"
                                      onsubmit="return confirm('¿Eliminar este parte?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" style="text-align:center;color:var(--muted);padding:2rem">No tienes partes registrados.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        {{ $partes->withQueryString()->links() }}
    </div>
</div>
@endsection