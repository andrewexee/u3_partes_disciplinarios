<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Alumno extends Model
{
    use HasFactory;

    protected $table = 'alumnos';

    protected $fillable = [
        'nombre',
        'apellidos',
        'grupo',
        'curso',
        'email_tutor',
        'nombre_tutor',
    ];

    /**
     * Un alumno puede tener muchos partes
     */
    public function partes()
    {
        return $this->hasMany(Parte::class, 'alumno_id');
    }

    /**
     * Buscar alumno por nombre o apellidos
     */
    public function scopeBuscar($query, $search)
    {
        return $query->where('nombre', 'like', "%{$search}%")
                     ->orWhere('apellidos', 'like', "%{$search}%");
    }

    /**
     * Filtrar por curso
     */
    public function scopeCurso($query, $curso)
    {
        return $query->where('curso', $curso);
    }

    /**
     * Nombre completo del alumno
     */
    public function getNombreCompletoAttribute(): string
    {
        return "{$this->nombre} {$this->apellidos}";
    }
}