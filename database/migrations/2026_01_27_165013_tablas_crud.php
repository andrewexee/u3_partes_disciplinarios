<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::create('alumnos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('grupo');
            $table->string('curso');
        });

        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('password');
        });

        Schema::create('partes', function (Blueprint $table) {
            $table->id();
            $table->foreignID('alumno_id')->references('id')->on('alumnos');
            $table->foreignID('teacher_id')->references('id')->on('teachers');
            $table->string('descripcion');
            $table->date('fecha');
            $table->string('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('partes');
        Schema::dropIfExists('teachers');
        Schema::dropIfExists('alumnos');
    }
};
