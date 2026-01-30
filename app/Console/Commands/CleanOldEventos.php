<?php

namespace App\Console\Commands;

use App\Models\Evento;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CleanOldEventos extends Command
{
    protected $signature = 'eventos:clean-old';

    protected $description = 'Eliminar eventos antiguos sin participantes';

    public function handle(): int
    {
        $this->info('Eliminando eventos antiguos sin participantes...');
        
        // Eliminar eventos antiguos (ID < 31) que no tienen participantes
        $eventosAntiguos = Evento::where('id', '<', 31)->get();
        
        foreach ($eventosAntiguos as $evento) {
            $participantes = DB::table('participantes')->where('evento_id', $evento->id)->count();
            if ($participantes == 0) {
                $this->line("Eliminando evento {$evento->id} ({$evento->name}) - sin participantes");
                $evento->delete();
            }
        }

        $this->info('¡Eventos antiguos eliminados!');
        $this->info('Los eventos con datos son los ID 31-40');

        return Command::SUCCESS;
    }
}

