<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Model
{
    use HasFactory;

    protected $table = 'teachers';

    protected $fillable = [
        'user_id',
        'nombre',
        'apellidos',
        'especialidad',
    ];

    /**
     * Cada teacher pertenece a un User de autenticación
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Un teacher puede haber creado muchos partes
     */
    public function partes()
    {
        return $this->hasMany(Parte::class, 'teacher_id');
    }

    /**
     * Nombre completo del profesor
     */
    public function getNombreCompletoAttribute(): string
    {
        return "{$this->nombre} {$this->apellidos}";
    }
}