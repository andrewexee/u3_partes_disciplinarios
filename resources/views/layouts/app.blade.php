<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gestión de Partes') — IES</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        /* ── VARIABLES ───────────────────────────────────── */
        :root {
            --navy:      #0f2342;
            --navy-mid:  #1a3a6b;
            --accent:    #c8962c;
            --accent-lt: #f0d080;
            --bg:        #f5f4f0;
            --surface:   #ffffff;
            --border:    #ddd9d0;
            --text:      #1a1a1a;
            --muted:     #6b6760;
            --danger:    #c0392b;
            --success:   #1e7e4e;
            --radius:    6px;
            --shadow:    0 2px 12px rgba(15,35,66,.10);
        }

        /* ── RESET ───────────────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
        }

        /* ── NAVBAR ──────────────────────────────────────── */
        .navbar {
            background: var(--navy);
            padding: 0 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 64px;
            box-shadow: 0 2px 8px rgba(0,0,0,.25);
            position: sticky; top: 0; z-index: 100;
        }
        .navbar-brand {
            font-family: 'DM Serif Display', serif;
            color: var(--accent-lt);
            font-size: 1.25rem;
            letter-spacing: .02em;
            text-decoration: none;
        }
        .navbar-brand span { color: #fff; font-size: .8rem; display: block; font-family: 'DM Sans', sans-serif; letter-spacing: .08em; text-transform: uppercase; font-weight: 300; }
        .nav-links { display: flex; align-items: center; gap: 0; }
        .nav-links a {
            color: rgba(255,255,255,.75);
            text-decoration: none;
            padding: 0 1rem;
            height: 64px;
            display: flex;
            align-items: center;
            font-size: .875rem;
            font-weight: 500;
            border-bottom: 3px solid transparent;
            transition: color .2s, border-color .2s;
        }
        .nav-links a:hover, .nav-links a.active {
            color: #fff;
            border-bottom-color: var(--accent);
        }
        .nav-user {
            display: flex; align-items: center; gap: .75rem;
            color: rgba(255,255,255,.6); font-size: .8rem;
        }
        .nav-user strong { color: #fff; }
        .btn-logout {
            background: rgba(255,255,255,.1);
            border: 1px solid rgba(255,255,255,.2);
            color: #fff;
            padding: .35rem .9rem;
            border-radius: var(--radius);
            font-size: .8rem;
            cursor: pointer;
            text-decoration: none;
            transition: background .2s;
        }
        .btn-logout:hover { background: rgba(255,255,255,.2); }

        /* ── CONTENEDOR ──────────────────────────────────── */
        .container { max-width: 1100px; margin: 0 auto; padding: 2rem 1.5rem; }

        /* ── ALERTAS ─────────────────────────────────────── */
        .alert {
            padding: .875rem 1.25rem;
            border-radius: var(--radius);
            margin-bottom: 1.5rem;
            font-size: .9rem;
            border-left: 4px solid;
        }
        .alert-success { background: #e8f5ee; border-color: var(--success); color: #145c38; }
        .alert-error   { background: #fdecea; border-color: var(--danger);  color: #7b1c14; }

        /* ── CARDS ───────────────────────────────────────── */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 8px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }
        .card-header {
            background: var(--navy);
            color: #fff;
            padding: 1.1rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .card-header h2 {
            font-family: 'DM Serif Display', serif;
            font-size: 1.15rem;
            font-weight: 400;
        }
        .card-body { padding: 1.5rem; }

        /* ── TABLA ───────────────────────────────────────── */
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: .9rem; }
        thead tr { background: var(--navy-mid); color: #fff; }
        thead th { padding: .75rem 1rem; text-align: left; font-weight: 500; letter-spacing: .04em; font-size: .8rem; text-transform: uppercase; }
        tbody tr { border-bottom: 1px solid var(--border); transition: background .15s; }
        tbody tr:hover { background: #f9f8f4; }
        tbody td { padding: .75rem 1rem; vertical-align: middle; }

        /* ── BADGES ──────────────────────────────────────── */
        .badge {
            display: inline-block;
            padding: .25rem .7rem;
            border-radius: 20px;
            font-size: .75rem;
            font-weight: 600;
            letter-spacing: .03em;
            text-transform: uppercase;
        }
        .badge-leve      { background: #e8f5ee; color: #1e7e4e; }
        .badge-grave     { background: #fff3cd; color: #856404; }
        .badge-muy_grave { background: #fdecea; color: #c0392b; }
        .badge-enviado   { background: #e3f2fd; color: #1565c0; }
        .badge-pendiente { background: #fafafa; color: #888; border: 1px solid #ddd; }

        /* ── BOTONES ─────────────────────────────────────── */
        .btn {
            display: inline-flex; align-items: center; gap: .4rem;
            padding: .5rem 1.1rem;
            border-radius: var(--radius);
            font-size: .875rem; font-weight: 500;
            text-decoration: none; cursor: pointer;
            border: none; transition: all .18s;
            font-family: 'DM Sans', sans-serif;
        }
        .btn-primary   { background: var(--navy); color: #fff; }
        .btn-primary:hover { background: var(--navy-mid); }
        .btn-accent    { background: var(--accent); color: #fff; }
        .btn-accent:hover { background: #b0831e; }
        .btn-sm        { padding: .35rem .8rem; font-size: .8rem; }
        .btn-outline   { background: transparent; border: 1.5px solid var(--border); color: var(--text); }
        .btn-outline:hover { border-color: var(--navy); color: var(--navy); }
        .btn-danger    { background: var(--danger); color: #fff; }
        .btn-danger:hover { background: #a93226; }
        .btn-success   { background: var(--success); color: #fff; }
        .btn-success:hover { background: #166038; }

        /* ── FORMULARIOS ─────────────────────────────────── */
        .form-group { margin-bottom: 1.25rem; }
        .form-group label { display: block; font-size: .85rem; font-weight: 600; margin-bottom: .4rem; color: var(--navy); }
        .form-control {
            width: 100%; padding: .6rem .9rem;
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            font-size: .9rem; font-family: 'DM Sans', sans-serif;
            transition: border-color .18s, box-shadow .18s;
            background: #fff;
        }
        .form-control:focus { outline: none; border-color: var(--navy-mid); box-shadow: 0 0 0 3px rgba(26,58,107,.12); }
        .form-control.is-invalid { border-color: var(--danger); }
        .invalid-feedback { color: var(--danger); font-size: .8rem; margin-top: .3rem; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        textarea.form-control { resize: vertical; min-height: 110px; }

        /* ── PAGINACIÓN ──────────────────────────────────── */
        .pagination { display: flex; gap: .25rem; justify-content: center; margin-top: 1.5rem; flex-wrap: wrap; }
        .pagination a, .pagination span {
            padding: .4rem .75rem; border-radius: var(--radius);
            font-size: .85rem; text-decoration: none;
            border: 1.5px solid var(--border); color: var(--text);
            transition: all .15s;
        }
        .pagination a:hover { border-color: var(--navy); color: var(--navy); }
        .pagination .active span { background: var(--navy); color: #fff; border-color: var(--navy); }
        .pagination .disabled span { color: #bbb; }

        /* ── PAGE HEADER ─────────────────────────────────── */
        .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; }
        .page-header h1 { font-family: 'DM Serif Display', serif; font-size: 1.6rem; color: var(--navy); font-weight: 400; }
        .page-header .breadcrumb { font-size: .8rem; color: var(--muted); margin-top: .15rem; }

        /* ── SEARCH BAR ──────────────────────────────────── */
        .search-bar { display: flex; gap: .75rem; margin-bottom: 1.25rem; flex-wrap: wrap; }
        .search-bar .form-control { max-width: 280px; }

        /* ── DETAIL ──────────────────────────────────────── */
        .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
        .detail-item label { font-size: .75rem; text-transform: uppercase; letter-spacing: .08em; color: var(--muted); font-weight: 600; display: block; margin-bottom: .2rem; }
        .detail-item p { font-size: .95rem; color: var(--text); }
        .detail-full { grid-column: 1 / -1; }

        /* ── ACCIONES TABLA ──────────────────────────────── */
        .actions { display: flex; gap: .4rem; flex-wrap: wrap; }

        /* ── RESPONSIVE ──────────────────────────────────── */
        @media (max-width: 640px) {
            .form-row { grid-template-columns: 1fr; }
            .detail-grid { grid-template-columns: 1fr; }
            .page-header { flex-direction: column; align-items: flex-start; gap: .75rem; }
        }
    </style>
</head>
<body>

<nav class="navbar">
    <a href="{{ route('partes.index') }}" class="navbar-brand">
        <span>Instituto</span>
        Gestión de Partes
    </a>

    @auth
    <div class="nav-links">
        <a href="{{ route('partes.index') }}"  class="{{ request()->routeIs('partes.*')  ? 'active' : '' }}">Partes</a>
        <a href="{{ route('alumnos.index') }}"  class="{{ request()->routeIs('alumnos.*')  ? 'active' : '' }}">Alumnos</a>
        <a href="{{ route('teachers.index') }}" class="{{ request()->routeIs('teachers.*') ? 'active' : '' }}">Profesores</a>
    </div>
    <div class="nav-user">
        @if(Auth::user()->esAdmin())
            <span style="background:var(--accent);color:#fff;padding:.2rem .6rem;border-radius:10px;font-size:.7rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase">
                Admin
            </span>
        @endif
        <span>Conectado como <strong>{{ Auth::user()->name }}</strong></span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout">Cerrar sesión</button>
        </form>
    </div>
    @endauth
</nav>

<div class="container">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    @yield('content')
</div>

</body>
</html>