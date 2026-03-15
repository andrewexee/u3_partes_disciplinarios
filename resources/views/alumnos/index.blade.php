@extends('layouts.app')
@section('title', 'Alumnos')

@section('content')
<div class="page-header">
    <div>
        <h1>Alumnos</h1>
        <div class="breadcrumb">Consulta del alumnado</div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2>Listado de alumnos</h2>
    </div>
    <div class="card-body">

        {{-- Barra de búsqueda --}}
        <form method="GET" action="{{ route('alumnos.index') }}" class="search-bar">
            <input type="text" name="search" class="form-control"
                   placeholder="Buscar por nombre o apellidos…"
                   value="{{ request('search') }}">
            <select name="curso" class="form-control" style="max-width:180px">
                <option value="">Todos los cursos</option>
                @foreach($cursos as $c)
                    <option value="{{ $c }}" {{ request('curso') == $c ? 'selected' : '' }}>{{ $c }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary">Buscar</button>
            @if(request()->hasAny(['search','curso']))
                <a href="{{ route('alumnos.index') }}" class="btn btn-outline">Limpiar</a>
            @endif
        </form>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Alumno</th>
                        <th>Grupo</th>
                        <th>Curso</th>
                        <th>Tutor</th>
                        <th>Partes</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @forelse($alumnos as $alumno)
                    <tr>
                        <td><strong>{{ $alumno->nombre_completo }}</strong></td>
                        <td>{{ $alumno->grupo }}</td>
                        <td>{{ $alumno->curso }}</td>
                        <td>{{ $alumno->nombre_tutor ?? '—' }}<br>
                            <small style="color:var(--muted)">{{ $alumno->email_tutor }}</small></td>
                        <td>
                            <span class="badge {{ $alumno->partes_count > 0 ? 'badge-grave' : 'badge-leve' }}">
                                {{ $alumno->partes_count ?? $alumno->partes->count() }}
                            </span>
                        </td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('alumnos.show', $alumno) }}" class="btn btn-outline btn-sm">Ver</a>
                                <a href="{{ route('partes.create', ['alumno_id' => $alumno->id]) }}"
                                   class="btn btn-accent btn-sm">+ Parte</a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" style="text-align:center;color:var(--muted);padding:2rem">No se encontraron alumnos.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{ $alumnos->withQueryString()->links() }}
    </div>
</div>
@endsection