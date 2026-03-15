<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // El orden es crítico por las claves foráneas:
        // 1. Users (necesarios antes que Teachers)
        // 2. Alumnos (independiente)
        // 3. Teachers (depende de Users)
        // 4. Partes (depende de Alumnos y Teachers)

        $this->call([
            UserSeeder::class,
            AlumnoSeeder::class,
            TeacherSeeder::class,
            ParteSeeder::class,
        ]);
    }
}