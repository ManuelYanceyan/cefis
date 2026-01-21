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
        for ($i = 1; $i <= 5000; $i++) {
            User::create([
                'paternal_surname' => 'paternal' . $i,
                'maternal_surname' => 'maternal' . $i,
                'name' => 'usuario' . $i,
                'email' => 'email' . $i . '@fis.edu',
                'password' => bcrypt('secreto'),
                'dni' => 10000000 + $i,
            ]);
        }
    }
}
