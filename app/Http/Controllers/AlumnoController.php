<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    /**
     * Listado con búsqueda opcional por nombre/apellidos.
     */
    public function index(Request $request)
    {
        $query = Alumno::query();

        // Búsqueda por nombre o apellidos
        if ($request->filled('search')) {
            $query->buscar($request->search);
        }

        // Filtro por curso
        if ($request->filled('curso')) {
            $query->curso($request->curso);
        }

        $alumnos = $query->orderBy('apellidos')->paginate(15);

        // Lista de cursos para el filtro del formulario
        $cursos = Alumno::select('curso')->distinct()->orderBy('curso')->pluck('curso');

        return view('alumnos.index', compact('alumnos', 'cursos'));
    }

    /**
     * Muestra el detalle de un alumno y sus partes asociados
     */
    public function show(Alumno $alumno)
    {
        $alumno->load(['partes.teacher']);

        return view('alumnos.show', compact('alumno'));
    }
}