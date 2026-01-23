<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Silber\Bouncer\BouncerFacade as Bouncer;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create-admin {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crear un usuario administrador';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        // Verificar si el usuario ya existe
        $existingUser = User::where('email', $email)->first();
        if ($existingUser) {
            $this->warn("El usuario con email {$email} ya existe.");
            $this->info("ID: {$existingUser->id}");
            $this->info("Nombre: {$existingUser->name}");
            $this->info("¿Deseas actualizar la contraseña? (usa: php artisan user:update-password {$email} nueva_password)");
            return Command::SUCCESS;
        }

        // Crear el usuario
        $user = User::create([
            'paternal_surname' => 'Admin',
            'maternal_surname' => 'User',
            'name' => 'Administrador',
            'email' => $email,
            'password' => Hash::make($password),
            'dni' => '00000000',
        ]);

        // Asignar rol de administrador
        Bouncer::assign('admin')->to($user);

        $this->info("Usuario administrador creado exitosamente:");
        $this->info("Email: {$email}");
        $this->info("Password: {$password}");

        return Command::SUCCESS;
    }
}
