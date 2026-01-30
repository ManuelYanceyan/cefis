<?php

namespace App\Imports;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\User;

class UsuariosImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
       DB::transaction(function () use ($rows) {
           foreach ($rows as $row) {
              User::create([
                'dni' =>$row['dni'],
                'paternal_surname' => $row['paternal_surname'],
                'maternal_surname' => $row['maternal_surname'],
                'name' => $row['nombres'],
                'email' => $row['dni']."@fis.edu",
                'password' => bcrypt('secreto')
              ]);
           }
       }); 
    }
}
