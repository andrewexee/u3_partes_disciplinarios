<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class TeacherController extends Controller
{
    /**
     * Listado de profesores
     */
    public function index()
    {
        $teachers = Teacher::with('user')->orderBy('apellidos')->paginate(15);

        return view('teachers.index', compact('teachers'));
    }

    /**
     * Formulario de creación
     */
    public function create()
    {
        // Usuarios sin teacher asignado aún
        $users = User::doesntHave('teacher')->get();

        return view('teachers.create', compact('users'));
    }

    /**
     * Almacenar nuevo teacher
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'       => 'required|string|max:100',
            'apellidos'    => 'required|string|max:100',
            'especialidad' => 'nullable|string|max:100',
            'user_id'      => 'required|exists:users,id|unique:teachers,user_id',
        ], [
            'user_id.unique' => 'Este usuario ya tiene un profesor asignado.',
            'user_id.exists' => 'El usuario seleccionado no existe.',
        ]);

        Teacher::create($validated);

        return redirect()->route('teachers.index')
                         ->with('success', 'Profesor creado correctamente.');
    }

    /**
     * Formulario de edición
     */
    public function edit(Teacher $teacher)
    {
        // Usuarios libres + el usuario actual del teacher
        $users = User::doesntHave('teacher')
                     ->orWhere('id', $teacher->user_id)
                     ->get();

        return view('teachers.edit', compact('teacher', 'users'));
    }

    /**
     * Actualizar teacher
     */
    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'nombre'       => 'required|string|max:100',
            'apellidos'    => 'required|string|max:100',
            'especialidad' => 'nullable|string|max:100',
            'user_id'      => [
                'required',
                'exists:users,id',
                Rule::unique('teachers', 'user_id')->ignore($teacher->id),
            ],
        ]);

        $teacher->update($validated);

        return redirect()->route('teachers.index')
                         ->with('success', 'Profesor actualizado correctamente.');
    }

    /**
     * Eliminar teacher
     */
    public function destroy(Teacher $teacher)
    {
        // Protección: no eliminar si tiene partes asociados
        if ($teacher->partes()->exists()) {
            return redirect()->route('teachers.index')
                             ->with('error', 'No se puede eliminar un profesor con partes asociados.');
        }

        $teacher->delete();

        return redirect()->route('teachers.index')
                         ->with('success', 'Profesor eliminado correctamente.');
    }
}