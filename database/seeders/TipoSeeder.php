<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoSeeder extends Seeder
{
    public function run(): void
    {
        // Tipos que deben existir
        $tipos = [
            'Preregistrado' => 'Preregistrado',
            'Registrado' => 'Registrado',
            'Certificado' => 'Certificado',
            'Organizador' => 'Organizador',
        ];

        // Insertar o actualizar cada tipo
        foreach ($tipos as $clave => $valor) {
            DB::table('tipos')->updateOrInsert(
                ['tip' => $clave],
                ['tip' => $valor, 'created_at' => now(), 'updated_at' => now()]
            );
        }

        // Mostrar los tipos creados
        $this->command->info('Tipos actualizados:');
        $tiposGuardados = DB::table('tipos')->get();
        foreach ($tiposGuardados as $tipo) {
            $this->command->info("ID: {$tipo->id} - {$tipo->tip}");
        }
    }
}
