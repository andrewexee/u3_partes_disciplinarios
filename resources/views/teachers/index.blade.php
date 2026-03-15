@extends('layouts.app')
@section('title', 'Profesores')

@section('content')
<div class="page-header">
    <div>
        <h1>Profesores</h1>
        <div class="breadcrumb">Gestión del profesorado</div>
    </div>
    <a href="{{ route('teachers.create') }}" class="btn btn-primary">+ Nuevo profesor</a>
</div>

<div class="card">
    <div class="card-header"><h2>Listado de profesores</h2></div>
    <div class="card-body">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr><th>Profesor</th><th>Especialidad</th><th>Usuario</th><th>Partes creados</th><th></th></tr>
                </thead>
                <tbody>
                @forelse($teachers as $teacher)
                    <tr>
                        <td><strong>{{ $teacher->nombre_completo }}</strong></td>
                        <td>{{ $teacher->especialidad ?? '—' }}</td>
                        <td>{{ $teacher->user->email }}</td>
                        <td>{{ $teacher->partes->count() }}</td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('teachers.edit', $teacher) }}" class="btn btn-outline btn-sm">Editar</a>
                                <form method="POST" action="{{ route('teachers.destroy', $teacher) }}"
                                      onsubmit="return confirm('¿Eliminar este profesor?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" style="text-align:center;color:var(--muted);padding:2rem">No hay profesores registrados.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        {{ $teachers->links() }}
    </div>
</div>
@endsection