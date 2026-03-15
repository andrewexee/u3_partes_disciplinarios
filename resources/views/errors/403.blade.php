@extends('layouts.app')
@section('title', 'Acceso denegado')

@section('content')
<div style="text-align:center;padding:4rem 1rem">
    <div style="font-size:4rem;margin-bottom:1rem">🔒</div>
    <h1 style="font-family:'DM Serif Display',serif;color:var(--navy);font-size:2rem;font-weight:400;margin-bottom:1rem">
        Acceso denegado
    </h1>
    <p style="color:var(--muted);max-width:420px;margin:0 auto 2rem">
        {{ $exception->getMessage() ?? 'No tienes permiso para acceder a esta sección.' }}
    </p>
    <a href="{{ url('/') }}" class="btn btn-primary">Volver al inicio</a>
</div>
@endsection