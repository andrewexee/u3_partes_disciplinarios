<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TeacherController extends Controller
{

    /**
     * Solo el admin puede gestionar profesores
     */
    private function soloAdmin(): void
    {
        abort_if(!Auth::user()->esAdmin(), 403, 'Solo el administrador puede gestionar profesores.');
    }

    /**
     * Listado de profesores
     */
    public function index()
    {
        // Profesores pueden ver el listado pero no crear/editar/eliminar
        $teachers = Teacher::with('user')->orderBy('apellidos')->paginate(15);
        $esAdmin  = Auth::user()->esAdmin();

        return view('teachers.index', compact('teachers', 'esAdmin'));
    }

    /**
     * Formulario de creación
     */
    public function create()
    {
        $this->soloAdmin();
        $users = User::doesntHave('teacher')->where('role', 'profesor')->get();
        return view('teachers.create', compact('users'));
    }

    /**
     * Almacenar nuevo teacher
     */
    public function store(Request $request)
    {
        $this->soloAdmin();
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
        $this->soloAdmin();
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
        $this->soloAdmin();
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
        $this->soloAdmin();
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