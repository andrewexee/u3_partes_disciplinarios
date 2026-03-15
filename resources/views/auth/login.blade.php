<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso al sistema — IES</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">

    <style>
        /* ── VARIABLES ───────────────────────────── */
        :root {
            --navy:       #0c1e35;
            --navy-deep:  #071526;
            --navy-mid:   #1a3a6b;
            --gold:       #c8962c;
            --gold-lt:    #e8c060;
            --cream:      #f8f6f1;
            --white:      #ffffff;
            --border:     #e2ddd5;
            --text:       #1a1a1a;
            --muted:      #6b6760;
            --danger:     #b83232;
            --radius:     5px;
        }

        /* ── RESET ───────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Lato', sans-serif;
            background: var(--navy-deep);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        /* ── WRAPPER SPLIT ───────────────────────── */
        .login-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            width: 100%;
            max-width: 860px;
            min-height: 520px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 32px 80px rgba(0,0,0,.55), 0 0 0 1px rgba(255,255,255,.05);
            animation: wrapperIn .55s cubic-bezier(.22,.68,0,1.2) both;
        }

        @keyframes wrapperIn {
            from { opacity: 0; transform: translateY(28px) scale(.97); }
            to   { opacity: 1; transform: translateY(0)   scale(1);    }
        }

        /* ── PANEL IZQUIERDO ─────────────────────── */
        .panel-left {
            background: var(--navy);
            padding: 3rem 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        /* Patrón geométrico de fondo */
        .panel-left::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                repeating-linear-gradient(
                    45deg,
                    rgba(255,255,255,.018) 0px,
                    rgba(255,255,255,.018) 1px,
                    transparent 1px,
                    transparent 28px
                );
            pointer-events: none;
        }

        /* Línea dorada decorativa superior */
        .panel-left::after {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--gold), var(--gold-lt), transparent);
        }

        .institute-label {
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: .18em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: .75rem;
            position: relative;
        }

        .institute-name {
            font-family: 'Playfair Display', serif;
            color: var(--white);
            font-size: 1.75rem;
            line-height: 1.25;
            font-weight: 600;
            position: relative;
        }

        .institute-name em {
            font-style: italic;
            color: var(--gold-lt);
            font-weight: 400;
        }

        .panel-divider {
            width: 40px;
            height: 2px;
            background: var(--gold);
            margin: 1.5rem 0;
            position: relative;
        }

        .panel-desc {
            color: rgba(255,255,255,.5);
            font-size: .85rem;
            line-height: 1.7;
            font-weight: 300;
            position: relative;
        }

        .panel-footer {
            position: relative;
        }

        .panel-footer-tag {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(255,255,255,.1);
            border-radius: 20px;
            padding: .4rem 1rem;
            font-size: .75rem;
            color: rgba(255,255,255,.45);
            letter-spacing: .06em;
        }

        .dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: var(--gold);
            display: inline-block;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50%       { opacity: .5; transform: scale(.75); }
        }

        /* ── PANEL DERECHO ───────────────────────── */
        .panel-right {
            background: var(--cream);
            padding: 3rem 2.75rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            color: var(--navy);
            margin-bottom: .35rem;
            font-weight: 600;
        }

        .form-subtitle {
            font-size: .85rem;
            color: var(--muted);
            margin-bottom: 2rem;
            font-weight: 300;
        }

        /* ── ALERTAS ─────────────────────────────── */
        .alert {
            padding: .75rem 1rem;
            border-radius: var(--radius);
            font-size: .85rem;
            margin-bottom: 1.5rem;
            border-left: 3px solid;
            animation: alertIn .3s ease both;
        }
        @keyframes alertIn {
            from { opacity: 0; transform: translateX(-8px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        .alert-error   { background: #fdecea; border-color: var(--danger); color: #7b1c14; }
        .alert-success { background: #e8f5ee; border-color: #1e7e4e; color: #145c38; }

        /* ── GRUPOS DE FORMULARIO ────────────────── */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-group label {
            display: block;
            font-size: .78rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--navy-mid);
            margin-bottom: .45rem;
        }

        .input-wrap {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: .9rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            font-size: 1rem;
            pointer-events: none;
            transition: color .2s;
        }

        .form-control {
            width: 100%;
            padding: .7rem 1rem .7rem 2.5rem;
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            font-size: .9rem;
            font-family: 'Lato', sans-serif;
            background: var(--white);
            color: var(--text);
            transition: border-color .2s, box-shadow .2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--navy-mid);
            box-shadow: 0 0 0 3px rgba(26,58,107,.1);
        }

        .form-control:focus + .input-icon,
        .input-wrap:focus-within .input-icon {
            color: var(--navy-mid);
        }

        .form-control.is-invalid {
            border-color: var(--danger);
            box-shadow: 0 0 0 3px rgba(184,50,50,.08);
        }

        .invalid-feedback {
            font-size: .78rem;
            color: var(--danger);
            margin-top: .3rem;
            display: block;
        }

        /* ── FILA REMEMBER + FORGOT ──────────────── */
        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            font-size: .82rem;
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: .45rem;
            color: var(--muted);
            cursor: pointer;
            user-select: none;
        }

        .remember-label input[type="checkbox"] {
            accent-color: var(--navy-mid);
            width: 15px;
            height: 15px;
            cursor: pointer;
        }

        .forgot-link {
            color: var(--navy-mid);
            text-decoration: none;
            font-weight: 400;
            transition: color .2s;
        }

        .forgot-link:hover { color: var(--gold); }

        /* ── BOTÓN SUBMIT ────────────────────────── */
        .btn-submit {
            width: 100%;
            padding: .8rem 1rem;
            background: var(--navy);
            color: var(--white);
            border: none;
            border-radius: var(--radius);
            font-family: 'Lato', sans-serif;
            font-size: .9rem;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            cursor: pointer;
            transition: background .2s, transform .15s, box-shadow .2s;
            position: relative;
            overflow: hidden;
        }

        .btn-submit::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(200,150,44,.15), transparent);
            opacity: 0;
            transition: opacity .2s;
        }

        .btn-submit:hover {
            background: var(--navy-mid);
            box-shadow: 0 6px 20px rgba(12,30,53,.35);
            transform: translateY(-1px);
        }

        .btn-submit:hover::after { opacity: 1; }
        .btn-submit:active { transform: translateY(0); box-shadow: none; }

        /* ── TOGGLE CONTRASEÑA ───────────────────── */
        .toggle-pass {
            position: absolute;
            right: .9rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--muted);
            font-size: .85rem;
            padding: .2rem;
            transition: color .2s;
        }
        .toggle-pass:hover { color: var(--navy); }

        /* ── RESPONSIVE ──────────────────────────── */
        @media (max-width: 640px) {
            .login-wrapper { grid-template-columns: 1fr; max-width: 420px; }
            .panel-left { padding: 2rem; min-height: auto; }
            .panel-right { padding: 2rem; }
            .institute-name { font-size: 1.4rem; }
        }
    </style>
</head>
<body>

<div class="login-wrapper">

    {{-- ── PANEL IZQUIERDO — IDENTIDAD ── --}}
    <div class="panel-left">
        <div>
            <div class="institute-label">Sistema de gestión</div>
            <h1 class="institute-name">
                Instituto<br>
                de <em>Educación</em><br>
                Secundaria
            </h1>
            <div class="panel-divider"></div>
            <p class="panel-desc">
                Plataforma de gestión de partes disciplinarios.
                Acceso exclusivo para el profesorado del centro.
            </p>
        </div>
        <div class="panel-footer">
            <div class="panel-footer-tag">
                <span class="dot"></span>
                Sistema activo
            </div>
        </div>
    </div>

    {{-- ── PANEL DERECHO — FORMULARIO ── --}}
    <div class="panel-right">
        <h2 class="form-title">Bienvenido</h2>
        <p class="form-subtitle">Introduce tus credenciales para acceder</p>

        {{-- Mensajes de error generales --}}
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Email --}}
            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <div class="input-wrap">
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}"
                        placeholder="usuario@ies.es"
                        required
                        autofocus
                        autocomplete="email"
                    >
                    <span class="input-icon">✉</span>
                </div>
                @error('email')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            {{-- Contraseña --}}
            <div class="form-group">
                <label for="password">Contraseña</label>
                <div class="input-wrap">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="••••••••"
                        required
                        autocomplete="current-password"
                    >
                    <span class="input-icon">🔑</span>
                    <button type="button" class="toggle-pass" onclick="togglePassword()" title="Mostrar/ocultar contraseña">
                        👁
                    </button>
                </div>
                @error('password')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            {{-- Recordarme + Olvidé contraseña --}}
            <div class="form-options">
                <label class="remember-label">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    Recordar sesión
                </label>
                @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-link">
                        ¿Olvidaste la contraseña?
                    </a>
                @endif
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn-submit">
                Iniciar sesión
            </button>

        </form>
    </div>

</div>

<script>
    function togglePassword() {
        const input = document.getElementById('password');
        const btn   = document.querySelector('.toggle-pass');
        if (input.type === 'password') {
            input.type = 'text';
            btn.textContent = '🙈';
        } else {
            input.type = 'password';
            btn.textContent = '👁';
        }
    }
</script>

</body>
</html>