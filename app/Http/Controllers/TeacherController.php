<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class TeacherController extends Controller
{
    // ── Solo el admin puede gestionar profesores ──────────────
    private function soloAdmin(): void
    {
        abort_if(!Auth::user()->esAdmin(), 403, 'Solo el administrador puede gestionar profesores.');
    }

    /**
     * Listado de profesores
     */
    public function index()
    {
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

        return view('teachers.create');
    }

    /**
     * Almacenar nuevo teacher + user juntos
     */
    public function store(Request $request)
    {
        $this->soloAdmin();

        $validated = $request->validate([
            // Datos del User
            'name'         => 'required|string|max:100',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|string|min:8|confirmed',
            // Datos del Teacher
            'nombre'       => 'required|string|max:100',
            'apellidos'    => 'required|string|max:100',
            'especialidad' => 'nullable|string|max:100',
        ], [
            'email.unique'       => 'Este email ya está registrado.',
            'password.min'       => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        // 1º — Crear el User con role profesor
        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'profesor',
        ]);

        // 2º — Crear el Teacher vinculado al User
        Teacher::create([
            'user_id'      => $user->id,
            'nombre'       => $validated['nombre'],
            'apellidos'    => $validated['apellidos'],
            'especialidad' => $validated['especialidad'] ?? null,
        ]);

        return redirect()->route('teachers.index')
                         ->with('success', 'Profesor y usuario creados correctamente.');
    }

    /**
     * Formulario de edición
     */
    public function edit(Teacher $teacher)
    {
        $this->soloAdmin();

        return view('teachers.edit', compact('teacher'));
    }

    /**
     * Actualizar teacher (y opcionalmente su user)
     */
    public function update(Request $request, Teacher $teacher)
    {
        $this->soloAdmin();

        $validated = $request->validate([
            // Datos del User
            'name'         => 'required|string|max:100',
            'email'        => ['required', 'email', Rule::unique('users', 'email')->ignore($teacher->user_id)],
            'password'     => 'nullable|string|min:8|confirmed',
            // Datos del Teacher
            'nombre'       => 'required|string|max:100',
            'apellidos'    => 'required|string|max:100',
            'especialidad' => 'nullable|string|max:100',
        ], [
            'email.unique'       => 'Este email ya está registrado por otro usuario.',
            'password.min'       => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        // Actualizar el User vinculado
        $userData = [
            'name'  => $validated['name'],
            'email' => $validated['email'],
        ];

        // Solo actualizar contraseña si se ha introducido una nueva
        if (!empty($validated['password'])) {
            $userData['password'] = Hash::make($validated['password']);
        }

        $teacher->user->update($userData);

        // Actualizar el Teacher
        $teacher->update([
            'nombre'       => $validated['nombre'],
            'apellidos'    => $validated['apellidos'],
            'especialidad' => $validated['especialidad'] ?? null,
        ]);

        return redirect()->route('teachers.index')
                         ->with('success', 'Profesor actualizado correctamente.');
    }

    /**
     * Eliminar teacher y su user asociado
     */
    public function destroy(Teacher $teacher)
    {
        $this->soloAdmin();

        if ($teacher->partes()->exists()) {
            return redirect()->route('teachers.index')
                             ->with('error', 'No se puede eliminar un profesor con partes asociados.');
        }

        // Guardar referencia al user antes de borrar el teacher
        $user = $teacher->user;

        $teacher->delete();
        $user->delete();

        return redirect()->route('teachers.index')
                         ->with('success', 'Profesor y usuario eliminados correctamente.');
    }
}