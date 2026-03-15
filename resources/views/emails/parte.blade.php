<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Georgia, serif; color: #1a1a1a; line-height: 1.7; margin: 0; padding: 0; background: #f5f4f0; }
        .wrapper { max-width: 600px; margin: 2rem auto; background: #fff; border: 1px solid #ddd; border-radius: 6px; overflow: hidden; }
        .header { background: #0f2342; color: #fff; padding: 1.5rem 2rem; }
        .header h1 { font-size: 1.1rem; margin: 0; font-weight: 400; letter-spacing: .04em; }
        .header p { margin: .25rem 0 0; font-size: .85rem; opacity: .7; }
        .body { padding: 2rem; }
        .badge { display:inline-block; padding:.3rem .9rem; border-radius:20px; font-size:.8rem; font-weight:700; }
        .badge-leve      { background:#e8f5ee; color:#1e7e4e; }
        .badge-grave     { background:#fff3cd; color:#856404; }
        .badge-muy_grave { background:#fdecea; color:#c0392b; }
        .motivo { background:#f9f8f4; border-left:4px solid #c8962c; padding:1rem 1.25rem; margin:1rem 0; border-radius:0 4px 4px 0; }
        .footer { background:#f5f4f0; border-top:1px solid #ddd; padding:1rem 2rem; font-size:.8rem; color:#888; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="header">
        <h1>Parte de apercibimiento</h1>
        <p>Notificación al tutor/a — IES</p>
    </div>
    <div class="body">
        <p>Estimado/a tutor/a,</p>
        <p>Le comunicamos que el alumno/a
           <strong>{{ $parte->alumno->nombre_completo }}</strong>
           del grupo <strong>{{ $parte->alumno->grupo }}</strong>
           ({{ $parte->alumno->curso }}) ha recibido un parte de apercibimiento.</p>

        <table style="width:100%;border-collapse:collapse;margin:1.25rem 0;font-size:.9rem">
            <tr style="background:#f5f4f0">
                <td style="padding:.6rem 1rem;font-weight:600;width:40%">Fecha</td>
                <td style="padding:.6rem 1rem">{{ $parte->fecha->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td style="padding:.6rem 1rem;font-weight:600">Tipo</td>
                <td style="padding:.6rem 1rem">
                    <span class="badge badge-{{ $parte->tipo }}">{{ $parte->tipo_label }}</span>
                </td>
            </tr>
            <tr style="background:#f5f4f0">
                <td style="padding:.6rem 1rem;font-weight:600">Profesor/a</td>
                <td style="padding:.6rem 1rem">{{ $parte->teacher->nombre_completo }}</td>
            </tr>
        </table>

        <p><strong>Descripción de los hechos:</strong></p>
        <div class="motivo">{{ $parte->descripcion }}</div>

        <p>Le rogamos se ponga en contacto con el centro si desea obtener más información.</p>
        <p>Atentamente,<br><strong>{{ $parte->teacher->nombre_completo }}</strong><br>IES</p>
    </div>
    <div class="footer">
        Este correo ha sido generado automáticamente por el sistema de gestión de partes del centro.
        Fecha de envío: {{ now()->format('d/m/Y H:i') }}.
    </div>
</div>
</body>
</html>