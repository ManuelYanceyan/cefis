<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ShowUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:show {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mostrar información de un usuario';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $email = $this->argument('email');

        // Buscar usando Eloquent
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("Usuario con email {$email} no encontrado.");
            return Command::FAILURE;
        }

        $this->info("=== Usuario encontrado ===");
        $this->table(
            ['Campo', 'Valor'],
            [
                ['ID', $user->id],
                ['Email', $user->email],
                ['Nombre', $user->name],
                ['Apellido Paterno', $user->paternal_surname],
                ['Apellido Materno', $user->maternal_surname],
                ['DNI', $user->dni],
                ['Creado', $user->created_at],
            ]
        );

        // Verificar directamente en la base de datos
        $dbUser = DB::table('users')->where('email', $email)->first();
        if ($dbUser) {
            $this->info("\n=== Verificación directa en BD ===");
            $this->info("Usuario encontrado en la tabla 'users' de la base de datos.");
            $this->info("Base de datos: " . DB::connection()->getDatabaseName());
        }

        return Command::SUCCESS;
    }
}

