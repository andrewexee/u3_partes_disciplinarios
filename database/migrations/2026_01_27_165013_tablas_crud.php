<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Se añade email_tutor para poder enviar el parte
        Schema::create('alumnos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellidos');
            $table->string('grupo');
            $table->string('curso');
            $table->string('email_tutor');
            $table->string('nombre_tutor')->nullable(); // Opcional pero útil
            $table->timestamps();
        });

        
        // Vinculo la tabla teachers con users para poder asignar un usuario a cada profesor
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')        // REQUISITO B: relación con users
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->string('nombre');
            $table->string('apellidos');        // Añadido
            $table->string('especialidad')->nullable();
            $table->timestamps();
        });

        // REQUISITO A: Partes de apercibimiento
        Schema::create('partes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alumno_id')
                  ->constrained('alumnos')
                  ->onDelete('restrict');       // No borrar alumno si tiene partes
            $table->foreignId('teacher_id')
                  ->constrained('teachers')
                  ->onDelete('restrict');       // No borrar profesor si tiene partes
            $table->text('descripcion');        // text en vez de string (más espacio)
            $table->date('fecha');
            $table->enum('tipo', [             // Añadido: categorizar el parte
                'leve', 
                'grave', 
                'muy_grave'
            ])->default('leve');
            $table->boolean('email_enviado')    // Saber si ya se envió
                  ->default(false);
            $table->timestamp('email_enviado_at')->nullable(); // Cuándo se envió
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partes');
        Schema::dropIfExists('teachers');
        Schema::dropIfExists('alumnos');
    }
};