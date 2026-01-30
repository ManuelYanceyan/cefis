<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddellware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Si no hay usuario autenticado, redirige al login
        if (!$user) {
            return redirect()->route('login');
        }

        // Verifica si el usuario es administrador
        if ($this->isAdmin($user)) {
            return $next($request);
        }

        // Si no es administrador, redirige al login con un mensaje de error
        return redirect()
            ->route('login')
            ->with('error', 'No tienes permisos de administrador.');
    }

    /**
     * Verifica si el usuario es administrador.
     * Ajusta esta lógica según tu sistema de roles/permisos.
     */
    protected function isAdmin($user): bool
    {
        // Opción 1: Si usas un campo 'is_admin' en la tabla users
        // return $user->is_admin === true;

        // Opción 2: Si usas spatie/laravel-permission
        // return $user->hasRole('admin');

        // Opción 3: Si tienes una relación de roles
        // return $user->roles()->where('name', 'admin')->exists();

        // Opción 4: Si el ID del usuario es 1 (solo para desarrollo)
        // return $user->id === 1;
        return true; // Permitir acceso a todos para pruebas
    }
}