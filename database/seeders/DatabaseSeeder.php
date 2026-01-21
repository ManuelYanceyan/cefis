<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {



        // User::factory(10)->create();

        /* User::factory(10)->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]); */

       $this->call([
            UserSeeder::class,                // automaticamnto obiene la ruta el usersicer ya sin copiar de nuevo en el userside
              ]);
        
              $this->call([
                UserSeeder::class,
                TipoSeeder::class,

              ]);
       
    }
}
