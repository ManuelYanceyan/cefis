<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evento;

class AdminController extends Controller
{
public function dashboard()
{
    // Usamos distinct() para evitar duplicados y paginate() para la paginación
    $eventos = Evento::select('id', 'name', 'fecha') // Seleccionamos solo los campos necesarios
        ->distinct('name') // Evitamos eventos con el mismo nombre
        ->orderBy('fecha', 'asc')
        ->paginate(10); // 10 eventos por página

    return view('admin.dashboard', compact('eventos'));
}
public function evento($evento_id)
{
    $evento = Evento::findOrFail($evento_id);
    $organizadores = $evento->organizadores;
    $ponentes = $evento->ponentes;
    $asistentes = $evento->asistentes;
    $preregistrados = $evento->pre_registrados; // Corregido el nombre del método
    
    return view('admin.evento', [
        'evento' => $evento,
        'organizadores' => $organizadores,
        'ponentes' => $ponentes,
        'asistentes' => $asistentes,
        'preregistrados' => $preregistrados  // Usando el mismo nombre de variable
    ]);
}
}
