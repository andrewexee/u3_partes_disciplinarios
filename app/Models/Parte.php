<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parte extends Model
{
    //
    protected $fillable = ['alumno_id', 'teacher_id', 'descripcion', 'fecha', 'email'];
}
