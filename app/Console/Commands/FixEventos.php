<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixEventos extends Command
{
    protected $signature = 'eventos:fix';

    protected $description = 'Limpiar eventos antiguos y recrear con participantes';

    public function handle(): int
    {
        $this->info('Limpiando eventos antiguos...');

        // Eliminar primero los participantes, luego los eventos
        DB::table('participantes')->delete();
        DB::table('eventos')->delete();

        $this->info('Ejecutando seeder de eventos...');
        $this->call('db:seed', ['--class' => 'EventoSeeder']);

        $this->info('¡Eventos recreados exitosamente!');

        return Command::SUCCESS;
    }
}
