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
     * Devuelve el teacher del usuario autenticado.
     * El admin no tiene teacher propio, devuelve null.
     */
    private function getTeacherAutenticado(): ?Teacher
    {
        if (Auth::user()->esAdmin()) {
            return null;
        }

        return Teacher::where('user_id', Auth::id())->firstOrFail();
    }

    /**
     * Listado — admin ve todo, profesor solo los suyos
     */
    public function index(Request $request)
    {
        $esAdmin = Auth::user()->esAdmin();
        $teacher = $this->getTeacherAutenticado();

        $query = Parte::with(['alumno', 'teacher']);

        // Si es profesor, filtrar solo sus partes
        if (!$esAdmin) {
            $query->delProfesor($teacher->id);
        }

        // Filtros opcionales
        if ($request->filled('tipo')) {
            $query->tipo($request->tipo);
        }

        if ($request->filled('alumno_id')) {
            $query->where('alumno_id', $request->alumno_id);
        }

        // Admin puede filtrar además por profesor
        if ($esAdmin && $request->filled('teacher_id')) {
            $query->where('teacher_id', $request->teacher_id);
        }

        $partes   = $query->orderByDesc('fecha')->paginate(15);
        $alumnos  = Alumno::orderBy('apellidos')->get();
        $teachers = $esAdmin ? Teacher::orderBy('apellidos')->get() : collect();

        return view('partes.index', compact('partes', 'alumnos', 'teachers', 'esAdmin'));
    }

    /**
     * Formulario de creación
     */
    public function create(Request $request)
    {
        $alumnos       = Alumno::orderBy('apellidos')->get();
        $alumnoSelecto = $request->filled('alumno_id')
                            ? Alumno::findOrFail($request->alumno_id)
                            : null;

        // Admin puede elegir en nombre de qué profesor crea el parte
        $teachers = Auth::user()->esAdmin()
                        ? Teacher::orderBy('apellidos')->get()
                        : collect();

        return view('partes.create', compact('alumnos', 'alumnoSelecto', 'teachers'));
    }

    /**
     * Guardar nuevo parte
     */
    public function store(Request $request)
    {
        $esAdmin = Auth::user()->esAdmin();

        $rules = [
            'alumno_id'   => 'required|exists:alumnos,id',
            'descripcion' => 'required|string|max:1000',
            'fecha'       => 'required|date',
            'tipo'        => 'required|in:leve,grave,muy_grave',
        ];

        // Admin debe seleccionar el profesor manualmente
        if ($esAdmin) {
            $rules['teacher_id'] = 'required|exists:teachers,id';
        }

        $validated = $request->validate($rules);

        // Si es profesor, asignar su teacher automáticamente
        if (!$esAdmin) {
            $validated['teacher_id'] = $this->getTeacherAutenticado()->id;
        }

        Parte::create($validated);

        return redirect()->route('partes.index')
                         ->with('success', 'Parte creado correctamente.');
    }

    /**
     * Ver detalle
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
        $alumnos  = Alumno::orderBy('apellidos')->get();
        $teachers = Auth::user()->esAdmin()
                        ? Teacher::orderBy('apellidos')->get()
                        : collect();

        return view('partes.edit', compact('parte', 'alumnos', 'teachers'));
    }

    /**
     * Actualizar parte
     */
    public function update(Request $request, Parte $parte)
    {
        $this->autorizarAcceso($parte);

        $rules = [
            'alumno_id'   => 'required|exists:alumnos,id',
            'descripcion' => 'required|string|max:1000',
            'fecha'       => 'required|date',
            'tipo'        => 'required|in:leve,grave,muy_grave',
        ];

        if (Auth::user()->esAdmin()) {
            $rules['teacher_id'] = 'required|exists:teachers,id';
        }

        $validated = $request->validate($rules);

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
     * Enviar correo al tutor
     */
    public function enviarEmail(Parte $parte)
    {
        $this->autorizarAcceso($parte);
        $parte->load(['alumno', 'teacher']);

        Mail::to($parte->alumno->email_tutor)->send(new ParteMail($parte));

        $parte->update([
            'email_enviado'    => true,
            'email_enviado_at' => now(),
        ]);

        return redirect()->route('partes.show', $parte)
                         ->with('success', "Correo enviado a {$parte->alumno->email_tutor}.");
    }

    /**
     * Admin accede a cualquier parte.
     * Profesor solo a los suyos.
     */
    private function autorizarAcceso(Parte $parte): void
    {
        if (Auth::user()->esAdmin()) {
            return;
        }

        $teacher = $this->getTeacherAutenticado();
        abort_if($parte->teacher_id !== $teacher->id, 403, 'No tienes permiso para acceder a este parte.');
    }
}