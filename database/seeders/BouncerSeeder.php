<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Silber\Bouncer\BouncerFacade as Bouncer;

class BouncerSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Crear rol de administrador
        $admin = Bouncer::role()->firstOrCreate([
            'name' => 'admin',
            'title' => 'Administrator',
        ]);

        // 2. Asignar rol a los primeros 4 usuarios
        for ($i = 1; $i <= 4; $i++) {
            if ($user = User::find($i)) {
                Bouncer::assign('admin')->to($user);
            }
        }

        // 3. (Opcional) Crear rol de organizador
        $organizador = Bouncer::role()->firstOrCreate([
            'name' => 'organizador',
            'title' => 'Organizador de Eventos',
        ]);

        // 4. (Opcional) Crear un permiso de ejemplo
        $permiso = Bouncer::ability()->firstOrCreate([
            'name' => 'gestionar-eventos',
            'title' => 'Puede gestionar eventos',
        ]);

        // 5. Asignar permiso al rol de administrador
        Bouncer::allow('admin')->to('gestionar-eventos');

        $this->command->info('Roles y permisos configurados correctamente');
    }
}
