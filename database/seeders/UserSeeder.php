<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usuario Administrador solicitado
        User::create([
            'paternal_surname' => 'Dendi',
            'maternal_surname' => 'User',
            'name' => 'Manuel',
            'email' => 'manueldendi@gmail.com',
            'password' => bcrypt('password123'),
            'dni' => '12345678',
        ]);

        // Generar 600 usuarios con formato secuencial
        for ($i = 1; $i <= 600; $i++) {
            User::create([
                'paternal_surname' => 'paternal ' . $i,
                'maternal_surname' => 'maternal ' . $i,
                'name' => 'name ' . $i,
                'email' => 'email' . $i . '@fis.edu',
                'password' => bcrypt('password'),
                'dni' => 10000000 + $i,
            ]);
        }
    }
}
