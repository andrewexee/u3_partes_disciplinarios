<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alumno;

class AlumnoSeeder extends Seeder
{
    public function run(): void
    {
        $alumnos = [
            // 1º ESO - A
            ['nombre' => 'Lucía',    'apellidos' => 'García Pérez',      'grupo' => '1ºA', 'curso' => '1º ESO', 'nombre_tutor' => 'Rosa Pérez',     'email_tutor' => 'rosa.perez@gmail.com'],
            ['nombre' => 'Marcos',   'apellidos' => 'López Fernández',   'grupo' => '1ºA', 'curso' => '1º ESO', 'nombre_tutor' => 'Juan López',      'email_tutor' => 'juan.lopez@gmail.com'],
            ['nombre' => 'Sofía',    'apellidos' => 'Martín Díaz',       'grupo' => '1ºA', 'curso' => '1º ESO', 'nombre_tutor' => 'Ana Díaz',        'email_tutor' => 'ana.diaz@hotmail.com'],
            ['nombre' => 'Daniel',   'apellidos' => 'González Moreno',   'grupo' => '1ºA', 'curso' => '1º ESO', 'nombre_tutor' => 'Luis González',   'email_tutor' => 'luis.gonzalez@gmail.com'],

            // 1º ESO - B
            ['nombre' => 'Paula',    'apellidos' => 'Jiménez Castro',    'grupo' => '1ºB', 'curso' => '1º ESO', 'nombre_tutor' => 'Carmen Castro',   'email_tutor' => 'carmen.castro@gmail.com'],
            ['nombre' => 'Adrián',   'apellidos' => 'Hernández Gil',     'grupo' => '1ºB', 'curso' => '1º ESO', 'nombre_tutor' => 'Marta Gil',       'email_tutor' => 'marta.gil@outlook.com'],
            ['nombre' => 'Elena',    'apellidos' => 'Ruiz Vargas',       'grupo' => '1ºB', 'curso' => '1º ESO', 'nombre_tutor' => 'Pedro Ruiz',      'email_tutor' => 'pedro.ruizv@gmail.com'],

            // 2º ESO - A
            ['nombre' => 'Hugo',     'apellidos' => 'Sánchez Blanco',    'grupo' => '2ºA', 'curso' => '2º ESO', 'nombre_tutor' => 'Pilar Blanco',    'email_tutor' => 'pilar.blanco@gmail.com'],
            ['nombre' => 'Valeria',  'apellidos' => 'Torres Iglesias',   'grupo' => '2ºA', 'curso' => '2º ESO', 'nombre_tutor' => 'Sergio Torres',   'email_tutor' => 'sergio.torres@gmail.com'],
            ['nombre' => 'Javier',   'apellidos' => 'Flores Ramos',      'grupo' => '2ºA', 'curso' => '2º ESO', 'nombre_tutor' => 'Isabel Ramos',    'email_tutor' => 'isabel.ramos@hotmail.com'],
            ['nombre' => 'Carmen',   'apellidos' => 'Morales Vega',      'grupo' => '2ºA', 'curso' => '2º ESO', 'nombre_tutor' => 'Francisco Vega',  'email_tutor' => 'fran.vega@gmail.com'],

            // 2º ESO - B
            ['nombre' => 'Alejandro','apellidos' => 'Ortiz Serrano',     'grupo' => '2ºB', 'curso' => '2º ESO', 'nombre_tutor' => 'Beatriz Serrano', 'email_tutor' => 'b.serrano@gmail.com'],
            ['nombre' => 'Nuria',    'apellidos' => 'Romero Molina',     'grupo' => '2ºB', 'curso' => '2º ESO', 'nombre_tutor' => 'Antonio Molina',  'email_tutor' => 'a.molina@outlook.com'],

            // 3º ESO - A
            ['nombre' => 'Sergio',   'apellidos' => 'Gutiérrez Campos',  'grupo' => '3ºA', 'curso' => '3º ESO', 'nombre_tutor' => 'Eva Campos',      'email_tutor' => 'eva.campos@gmail.com'],
            ['nombre' => 'Andrea',   'apellidos' => 'Muñoz Reyes',       'grupo' => '3ºA', 'curso' => '3º ESO', 'nombre_tutor' => 'Manuel Reyes',    'email_tutor' => 'manuel.reyes@gmail.com'],
            ['nombre' => 'Pablo',    'apellidos' => 'Álvarez Navarro',   'grupo' => '3ºA', 'curso' => '3º ESO', 'nombre_tutor' => 'Dolores Navarro', 'email_tutor' => 'd.navarro@hotmail.com'],

            // 3º ESO - B
            ['nombre' => 'Irene',    'apellidos' => 'Domínguez Prieto',  'grupo' => '3ºB', 'curso' => '3º ESO', 'nombre_tutor' => 'Jorge Prieto',    'email_tutor' => 'jorge.prieto@gmail.com'],
            ['nombre' => 'Rubén',    'apellidos' => 'Gil Santos',        'grupo' => '3ºB', 'curso' => '3º ESO', 'nombre_tutor' => 'Cristina Santos', 'email_tutor' => 'c.santos@gmail.com'],

            // 4º ESO - A
            ['nombre' => 'Alba',     'apellidos' => 'Núñez Fuentes',     'grupo' => '4ºA', 'curso' => '4º ESO', 'nombre_tutor' => 'Roberto Fuentes', 'email_tutor' => 'r.fuentes@gmail.com'],
            ['nombre' => 'Víctor',   'apellidos' => 'Pascual Medina',    'grupo' => '4ºA', 'curso' => '4º ESO', 'nombre_tutor' => 'Teresa Medina',   'email_tutor' => 't.medina@outlook.com'],

            // 1º BACH - A
            ['nombre' => 'Marina',   'apellidos' => 'Herrera Gallego',   'grupo' => '1ºA', 'curso' => '1º Bach', 'nombre_tutor' => 'Ángel Gallego',  'email_tutor' => 'angel.gallego@gmail.com'],
            ['nombre' => 'Óscar',    'apellidos' => 'Vidal Guerrero',    'grupo' => '1ºA', 'curso' => '1º Bach', 'nombre_tutor' => 'Silvia Guerrero', 'email_tutor' => 's.guerrero@gmail.com'],

            // 2º BACH - A
            ['nombre' => 'Claudia',  'apellidos' => 'Peña Montero',      'grupo' => '2ºA', 'curso' => '2º Bach', 'nombre_tutor' => 'Raúl Montero',   'email_tutor' => 'raul.montero@gmail.com'],
            ['nombre' => 'Diego',    'apellidos' => 'Cabrera Soler',     'grupo' => '2ºA', 'curso' => '2º Bach', 'nombre_tutor' => 'Patricia Soler',  'email_tutor' => 'p.soler@hotmail.com'],
        ];

        foreach ($alumnos as $alumno) {
            Alumno::firstOrCreate(
                ['nombre' => $alumno['nombre'], 'apellidos' => $alumno['apellidos']],
                $alumno
            );
        }
    }
}