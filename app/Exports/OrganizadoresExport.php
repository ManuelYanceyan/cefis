<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Evento;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrganizadoresExport implements FromCollection, WithHeadings, WithMapping
{
    protected $evento_id;

    public function __construct($evento_id)
    {
        $this->evento_id = $evento_id;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Obtener usuarios que son organizadores del evento dado
        return User::whereHas('eventos', function($query) {
            $query->where('evento_id', $this->evento_id)
                  ->where('tipo_id', 4); // 4 es el ID para Organizadores
        })->get();
    }

    public function map($organizador): array
    {
        return [
            $organizador->dni,
            $organizador->paternal_surname,
            $organizador->maternal_surname,
            $organizador->name,
            $organizador->email,
            'Organizador'
        ];
    }

    public function headings(): array
    {
        return [
            'DNI',
            'Apellido Paterno',
            'Apellido Materno',
            'Nombres',
            'Email',
            'Rol'
        ];
    }
}
