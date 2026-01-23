<?php

namespace Database\Seeders;

use App\Models\Evento;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventoSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener los IDs de los tipos
        $tipos = [
            'Preregistrado' => 1,
            'Registrado' => 2,
            'Certificado' => 3,
            'Organizador' => 4,
        ];

        // Crear 10 eventos
        for ($i = 1; $i <= 10; $i++) {
            $evento = Evento::create([
                'name' => 'Evento '.$i,
                'fecha' => now()->addDays($i),
                'address' => 'Dirección '.$i.', Ciudad',
            ]);

            // Asignar 4 ponentes (Certificado)
            $maxUserId = DB::table('users')->max('id');
            $ponentesAsignados = 0;
            $intentos = 0;

            while ($ponentesAsignados < 4 && $intentos < 20) {
                $userId = mt_rand(1, $maxUserId);

                // Verificar si el usuario existe
                $usuarioExiste = DB::table('users')->where('id', $userId)->exists();

                if ($usuarioExiste) {
                    try {
                        $evento->ponentes()->syncWithoutDetaching([
                            $userId => ['tipo_id' => $tipos['Certificado']],
                        ]);
                        $ponentesAsignados++;
                    } catch (\Exception $e) {
                        // Ignorar errores de duplicados
                    }
                }
                $intentos++;
            }

            // Asignar 10 organizadores (Organizador)
            $organizadoresAsignados = 0;
            $intentos = 0;

            while ($organizadoresAsignados < 10 && $intentos < 50) {
                $userId = mt_rand(1, $maxUserId);

                // Verificar si el usuario existe
                $usuarioExiste = DB::table('users')->where('id', $userId)->exists();

                if ($usuarioExiste) {
                    try {
                        $evento->organizadores()->syncWithoutDetaching([
                            $userId => ['tipo_id' => $tipos['Organizador']],
                        ]);
                        $organizadoresAsignados++;
                    } catch (\Exception $e) {
                        // Ignorar errores de duplicados
                    }
                }
                $intentos++;
            }

            // Asignar 200-300 asistentes (Preregistrado)
            $totalAsistentes = rand(200, 300);
            $asignados = 0;
            $intentos = 0;
            $maxIntentos = $totalAsistentes * 2;

            while ($asignados < $totalAsistentes && $intentos < $maxIntentos) {
                $userId = mt_rand(1, $maxUserId);

                // Verificar si el usuario existe
                $usuarioExiste = DB::table('users')->where('id', $userId)->exists();

                if ($usuarioExiste) {
                    try {
                        $evento->asistentes()->syncWithoutDetaching([
                            $userId => ['tipo_id' => $tipos['Preregistrado']],
                        ]);
                        $asignados++;
                    } catch (\Exception $e) {
                        if (! str_contains($e->getMessage(), 'Duplicate entry')) {
                            $this->command->error('Error al asignar asistente: '.$e->getMessage());
                        }
                    }
                }
                $intentos++;
            }

            $this->command->info("Evento $i creado con éxito. Asistentes asignados: $asignados de $totalAsistentes");
        }
    }
}
