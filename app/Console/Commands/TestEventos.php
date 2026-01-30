<?php

namespace App\Console\Commands;

use App\Models\Evento;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TestEventos extends Command
{
    protected $signature = 'eventos:test';

    protected $description = 'Verificar participantes en eventos';

    public function handle(): int
    {
        $this->info('Verificando eventos y participantes...');
        
        $eventos = Evento::all();
        
        foreach ($eventos as $evento) {
            $total = DB::table('participantes')->where('evento_id', $evento->id)->count();
            $org = $evento->organizadores()->count();
            $pon = $evento->ponentes()->count();
            $asi = $evento->asistentes()->count();
            $pre = $evento->pre_registrados()->count();
            
            $this->line("Evento {$evento->id} ({$evento->name}):");
            $this->line("  Total en BD: {$total}");
            $this->line("  Organizadores: {$org}");
            $this->line("  Ponentes: {$pon}");
            $this->line("  Asistentes: {$asi}");
            $this->line("  Preregistrados: {$pre}");
            $this->line('');
        }

        return Command::SUCCESS;
    }
}

