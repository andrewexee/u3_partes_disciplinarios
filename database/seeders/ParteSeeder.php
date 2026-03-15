<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Parte;
use App\Models\Alumno;
use App\Models\Teacher;

class ParteSeeder extends Seeder
{
    public function run(): void
    {
        // Necesitamos al menos alumnos y teachers ya insertados
        $teachers = Teacher::all();
        $alumnos  = Alumno::all();

        if ($teachers->isEmpty() || $alumnos->isEmpty()) {
            $this->command->warn('⚠ No hay profesores o alumnos. Ejecuta antes UserSeeder, TeacherSeeder y AlumnoSeeder.');
            return;
        }

        $partes = [
            [
                'alumno'      => ['nombre' => 'Marcos',    'apellidos' => 'López Fernández'],
                'teacher'     => ['nombre' => 'Victor',    'apellidos' => 'García Villarán'],
                'descripcion' => 'El alumno interrumpió repetidamente la clase, impidiendo el normal desarrollo de la sesión a pesar de las advertencias previas.',
                'fecha'       => '2025-09-15',
                'tipo'        => 'leve',
                'email_enviado'    => true,
                'email_enviado_at' => '2025-09-15 10:30:00',
            ],
            [
                'alumno'      => ['nombre' => 'Daniel',    'apellidos' => 'González Moreno'],
                'teacher'     => ['nombre' => 'Santiago',     'apellidos' => 'Camacho Sanchez'],
                'descripcion' => 'El alumno se negó a realizar las actividades propuestas y respondió de forma irrespetuosa cuando se le indicó que debía ponerse a trabajar.',
                'fecha'       => '2025-10-03',
                'tipo'        => 'grave',
                'email_enviado'    => true,
                'email_enviado_at' => '2025-10-03 12:00:00',
            ],
            [
                'alumno'      => ['nombre' => 'Adrián',    'apellidos' => 'Hernández Gil'],
                'teacher'     => ['nombre' => 'Pedro',     'apellidos' => 'Ruiz Castillo'],
                'descripcion' => 'El alumno fue sorprendido copiando durante el examen de evaluación. Se le retiró el examen y se le comunicó que tendría calificación de cero.',
                'fecha'       => '2025-10-22',
                'tipo'        => 'grave',
                'email_enviado'    => false,
                'email_enviado_at' => null,
            ],
            [
                'alumno'      => ['nombre' => 'Hugo',      'apellidos' => 'Sánchez Blanco'],
                'teacher'     => ['nombre' => 'María',     'apellidos' => 'Torres Aguado'],
                'descripcion' => 'El alumno protagonizó un enfrentamiento físico con otro compañero en el pasillo durante el cambio de clase, requiriendo intervención del profesorado.',
                'fecha'       => '2025-11-08',
                'tipo'        => 'muy_grave',
                'email_enviado'    => true,
                'email_enviado_at' => '2025-11-08 14:15:00',
            ],
            [
                'alumno'      => ['nombre' => 'Alejandro', 'apellidos' => 'Ortiz Serrano'],
                'teacher'     => ['nombre' => 'Carlos',    'apellidos' => 'Martínez Romero'],
                'descripcion' => 'El alumno llegó tarde por tercera vez consecutiva sin justificación, alterando el inicio de la sesión.',
                'fecha'       => '2025-11-20',
                'tipo'        => 'leve',
                'email_enviado'    => false,
                'email_enviado_at' => null,
            ],
            [
                'alumno'      => ['nombre' => 'Rubén',     'apellidos' => 'Gil Santos'],
                'teacher'     => ['nombre' => 'Laura',     'apellidos' => 'Sánchez Vidal'],
                'descripcion' => 'El alumno utilizó el teléfono móvil durante la explicación ignorando las advertencias del profesor y grabando sin consentimiento a compañeros.',
                'fecha'       => '2025-12-01',
                'tipo'        => 'grave',
                'email_enviado'    => false,
                'email_enviado_at' => null,
            ],
            [
                'alumno'      => ['nombre' => 'Pablo',     'apellidos' => 'Álvarez Navarro'],
                'teacher'     => ['nombre' => 'Pedro',     'apellidos' => 'Ruiz Castillo'],
                'descripcion' => 'El alumno abandonó el aula sin permiso durante la clase y no regresó hasta el final del período lectivo.',
                'fecha'       => '2026-01-14',
                'tipo'        => 'grave',
                'email_enviado'    => true,
                'email_enviado_at' => '2026-01-14 11:45:00',
            ],
            [
                'alumno'      => ['nombre' => 'Marcos',    'apellidos' => 'López Fernández'],
                'teacher'     => ['nombre' => 'María',     'apellidos' => 'Torres Aguado'],
                'descripcion' => 'Reincidencia: el alumno volvió a interrumpir la clase de forma deliberada con comentarios inapropiados dirigidos a una compañera.',
                'fecha'       => '2026-02-03',
                'tipo'        => 'grave',
                'email_enviado'    => false,
                'email_enviado_at' => null,
            ],
        ];

        foreach ($partes as $data) {
            $alumno  = $alumnos->where('nombre', $data['alumno']['nombre'])
                               ->where('apellidos', $data['alumno']['apellidos'])
                               ->first();

            $teacher = $teachers->where('nombre', $data['teacher']['nombre'])
                                ->where('apellidos', $data['teacher']['apellidos'])
                                ->first();

            if (!$alumno || !$teacher) {
                $this->command->warn("⚠ No se encontró alumno o profesor para un parte. Saltando...");
                continue;
            }

            Parte::firstOrCreate(
                [
                    'alumno_id'  => $alumno->id,
                    'teacher_id' => $teacher->id,
                    'fecha'      => $data['fecha'],
                ],
                [
                    'descripcion'      => $data['descripcion'],
                    'tipo'             => $data['tipo'],
                    'email_enviado'    => $data['email_enviado'],
                    'email_enviado_at' => $data['email_enviado_at'],
                ]
            );
        }

        $this->command->info('✓ Partes insertados correctamente.');
    }
}