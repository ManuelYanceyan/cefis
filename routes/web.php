<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Middleware\Admin\AdminMiddellware;
use Illuminate\Support\Facades\Route;

// Rutas públicas
Route::get('/', [LoginController::class, 'getLogin'])->name('login');
Route::post('/', [LoginController::class, 'login'])->name('login.post');

// Ruta Pública de Verificación de Certificados
Route::get('/verificar/{evento_id}/{certificado_id}', [AdminController::class, 'verifyCertificado'])->name('certificado.verify');



// Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {
    // Ruta de cierre de sesión
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Rutas de administrador (protegidas por autenticación y middleware de admin)
    Route::middleware('admin')->group(function () {
        // Dashboard principal
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Configuración Global de Certificado
        Route::get('/configurar-certificado', [AdminController::class, 'getConfigCertificado'])->name('configurar-certificado');
        Route::post('/configurar-certificado', [AdminController::class, 'postConfigCertificado'])->name('store-config-certificado');
        
        // Gestión de eventos
        Route::prefix('eventos')->group(function () {
            Route::get('/crear', [AdminController::class, 'getAddEvento'])->name('eventos.create');
            Route::post('/guardar', [AdminController::class, 'postAddEvent'])->name('eventos.store');
            Route::get('/{evento_id}', [AdminController::class, 'evento'])->name('eventos.show');
            Route::prefix('/evento/{evento_id}')->group(function () {
                Route::get('/', [AdminController::class, 'evento'])->name('evento');
                Route::get('/add-certificado-base', [AdminController::class, 'getAddCertificadoBase'])->name('add-certificado-base');
                Route::get('/add-organizador', [AdminController::class, 'getAddOrganizador'])->name('add-organizador');
                Route::post('/add-organizador', [AdminController::class, 'postAddOrganizador'])->name('store-organizador-evento');
                Route::post('/certificado-base', [AdminController::class, 'postAddCertificadoBase'])->name('store-certificado-base');
                // Ponentes
                Route::get('/add-ponente', [AdminController::class, 'getAddPonente'])->name('add-ponente');
                Route::post('/add-ponente', [AdminController::class, 'postAddPonente'])->name('store-ponente-evento');

                // Asistentes
                Route::get('/add-asistente', [AdminController::class, 'getAddAsistente'])->name('add-asistente');
                Route::post('/add-asistente', [AdminController::class, 'postAddAsistente'])->name('store-asistente-evento');

                // Preregistrados
                Route::get('/add-preregistrado', [AdminController::class, 'getAddPreregistrado'])->name('add-preregistrado');
                Route::post('/add-preregistrado', [AdminController::class, 'postAddPreregistrado'])->name('store-preregistrado-evento');
                Route::get('/certificados/organizadores', [AdminController::class, 'generarCertificadoOrganizadores'])->name('generate-certificados-organizadores');
                Route::get('/certificados/ponentes', [AdminController::class, 'generarCertificadoPonentes'])->name('generate-certificados-ponentes');
                Route::get('/certificados/asistentes', [AdminController::class, 'generarCertificadoAsistentes'])->name('generate-certificados-asistentes');
                Route::get('/certificados/preregistrados', [AdminController::class, 'generarCertificadoPreregistrados'])->name('generate-certificados-preregistrados');
                Route::get('/certificados', [AdminController::class, 'certificados'])->name('admin-certificados');
                Route::get('/certificado/{certificado_id}/descargar', [AdminController::class, 'downloadCertificado'])->name('certificado.download');
                
                // Exportar
                Route::get('/exportar-organizadores', [AdminController::class, 'exportOrganizadores'])->name('export-organizadores');
                
                
            });
        });
    });
});