<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;
use App\Models\User;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        // Mapeamos cada email de usuario con los datos del profesor
        // El usuario 'admin@ies.es' no tiene teacher (es solo administrador)
        $teachers = [
            [
                'email'        => 'v.garcia@iesdh.es',
                'nombre'       => 'Victor',
                'apellidos'    => 'García Villarán',
                'especialidad' => 'Informática y PHP',
            ],
            [
                'email'        => 's.camacho@iesdh.es',
                'nombre'       => 'Santiago',
                'apellidos'    => 'Camacho Sanchez',
                'especialidad' => 'Informática y JS',
            ],
            [
                'email'        => 'i.cano@iesdh.es',
                'nombre'       => 'Ismael',
                'apellidos'    => 'Cano Huelva',
                'especialidad' => 'Explosivos y Pirotecnia',
            ],
            [
                'email'        => 'a.iglesias@iesdh.es',
                'nombre'       => 'Andrés',
                'apellidos'    => 'Iglesias Camacho',
                'especialidad' => 'Programación y Aura',
            ],
        ];

        foreach ($teachers as $data) {
            $user = User::where('email', $data['email'])->first();

            if ($user) {
                Teacher::firstOrCreate(
                    ['user_id' => $user->id],
                    [
                        'nombre'       => $data['nombre'],
                        'apellidos'    => $data['apellidos'],
                        'especialidad' => $data['especialidad'],
                    ]
                );
            }
        }
    }
}