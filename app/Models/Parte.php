<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Parte extends Model
{
    use HasFactory;

    protected $table = 'partes';

    protected $fillable = [
        'alumno_id',
        'teacher_id',
        'descripcion',
        'fecha',
        'tipo',
        'email_enviado',
        'email_enviado_at',
    ];

    protected $casts = [
        'fecha'            => 'date',
        'email_enviado'    => 'boolean',
        'email_enviado_at' => 'datetime',
    ];

    /**
     * Un parte pertenece a un alumno
     */
    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'alumno_id');
    }

    /**
     * Un parte fue creado por un teacher
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    /**
     * Filtrar partes del profesor autenticado
     */
    public function scopeDelProfesor($query, $teacherId)
    {
        return $query->where('teacher_id', $teacherId);
    }

    /**
     * Filtrar por tipo de parte
     */
    public function scopeTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    /**
     * Partes cuyo correo aún no ha sido enviado
     */
    public function scopeNoEnviados($query)
    {
        return $query->where('email_enviado', false);
    }

    /**
     * Etiqueta legible del tipo de parte
     */
    public function getTipoLabelAttribute(): string
    {
        return match($this->tipo) {
            'leve'      => 'Leve',
            'grave'     => 'Grave',
            'muy_grave' => 'Muy grave',
            default     => 'Desconocido',
        };
    }
}