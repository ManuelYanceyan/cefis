<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipos')->insert([
            [
                'tip' => 'Preregistrado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tip' => 'Registrado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tip' => 'Certificado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
