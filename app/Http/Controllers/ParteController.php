<?php

namespace App\Http\Controllers;

use App\Models\Parte;
use App\Models\Alumno;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ParteMail;

class ParteController extends Controller
{
    /**
     * Obtiene el teacher vinculado al usuario autenticado
     */
    private function getTeacherAutenticado(): Teacher
    {
        return Teacher::where('user_id', Auth::id())->firstOrFail();
    }

    /**
     * Listado de partes
     * El profesor solo ve sus propios partes
     */
    public function index(Request $request)
    {
        $teacher = $this->getTeacherAutenticado();

        $query = Parte::with(['alumno', 'teacher'])
                      ->delProfesor($teacher->id);

        // Filtro por tipo
        if ($request->filled('tipo')) {
            $query->tipo($request->tipo);
        }

        // Filtro por alumno
        if ($request->filled('alumno_id')) {
            $query->where('alumno_id', $request->alumno_id);
        }

        $partes  = $query->orderByDesc('fecha')->paginate(15);
        $alumnos = Alumno::orderBy('apellidos')->get();

        return view('partes.index', compact('partes', 'alumnos'));
    }

    /**
     * Formulario para crear un parte
     * Puede recibir alumno_id desde la vista de alumnos
     */
    public function create(Request $request)
    {
        $alumnos       = Alumno::orderBy('apellidos')->get();
        $alumnoSelecto = $request->filled('alumno_id')
                            ? Alumno::findOrFail($request->alumno_id)
                            : null;

        return view('partes.create', compact('alumnos', 'alumnoSelecto'));
    }

    /**
     * Guardar nuevo parte (Requisito A)
     */
    public function store(Request $request)
    {
        $teacher = $this->getTeacherAutenticado();

        $validated = $request->validate([
            'alumno_id'   => 'required|exists:alumnos,id',
            'descripcion' => 'required|string|max:1000',
            'fecha'       => 'required|date',
            'tipo'        => 'required|in:leve,grave,muy_grave',
        ]);

        // El teacher_id se asigna automáticamente desde la sesión
        $validated['teacher_id'] = $teacher->id;

        Parte::create($validated);

        return redirect()->route('partes.index')
                         ->with('success', 'Parte creado correctamente.');
    }

    /**
     * Ver detalle de un parte
     */
    public function show(Parte $parte)
    {
        $this->autorizarAcceso($parte);

        $parte->load(['alumno', 'teacher.user']);

        return view('partes.show', compact('parte'));
    }

    /**
     * Formulario de edición
     */
    public function edit(Parte $parte)
    {
        $this->autorizarAcceso($parte);

        $alumnos = Alumno::orderBy('apellidos')->get();

        return view('partes.edit', compact('parte', 'alumnos'));
    }

    /**
     * Actualizar parte
     */
    public function update(Request $request, Parte $parte)
    {
        $this->autorizarAcceso($parte);

        $validated = $request->validate([
            'alumno_id'   => 'required|exists:alumnos,id',
            'descripcion' => 'required|string|max:1000',
            'fecha'       => 'required|date',
            'tipo'        => 'required|in:leve,grave,muy_grave',
        ]);

        $parte->update($validated);

        return redirect()->route('partes.index')
                         ->with('success', 'Parte actualizado correctamente.');
    }

    /**
     * Eliminar parte
     */
    public function destroy(Parte $parte)
    {
        $this->autorizarAcceso($parte);

        $parte->delete();

        return redirect()->route('partes.index')
                         ->with('success', 'Parte eliminado correctamente.');
    }

    /**
     * Enviar el parte por correo al tutor del alumno
     */
    public function enviarEmail(Parte $parte)
    {
        $this->autorizarAcceso($parte);

        $parte->load(['alumno', 'teacher']);

        // Enviar correo al email_tutor del alumno
        Mail::to($parte->alumno->email_tutor)
            ->send(new ParteMail($parte));

        // Marcar como enviado
        $parte->update([
            'email_enviado'    => true,
            'email_enviado_at' => now(),
        ]);

        return redirect()->route('partes.show', $parte)
                         ->with('success', "Correo enviado a {$parte->alumno->email_tutor}.");
    }

    /**
     * Solo el profesor que creó el parte puede acceder a él
     */
    private function autorizarAcceso(Parte $parte): void
    {
        $teacher = $this->getTeacherAutenticado();

        abort_if($parte->teacher_id !== $teacher->id, 403, 'No tienes permiso para acceder a este parte.');
    }
}