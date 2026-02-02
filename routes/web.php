<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Middleware\Admin\AdminMiddleware;

Route::get('/', [LoginController::class, "getLogin"])->name('login');
Route::post('/', [LoginController::class, "login"]);
Route::middleware('auth')->group(function () {
	Route::get('/logout', [LoginController::class, "logout"])->name('logout');
	Route::middleware(AdminMiddleware::class)->group(function () {
		Route::get('/dashboard', [AdminController::class, "getDashboard"])->name('dashboard');
		Route::get('/add-evento', [AdminController::class, "getAddEvento"])->name('add-evento');
		Route::post('/add-evento', [AdminController::class, "postAddEvento"]);
		Route::prefix('/evento/{evento_id}')->group(function () {
			Route::get('/', [AdminController::class, "evento"])->name('evento');
			Route::get('/add-certificado-base', [AdminController::class, "getAddCertificadoBase"])->name('add-certificado-base');
			Route::post('/add-certificado-base', [AdminController::class, "postAddCertificadoBase"]);
			Route::get('/add-organizador', [AdminController::class, "getAddOrganizador"])->name('add-organizador');
			Route::post('/add-organizador', [AdminController::class, "postAddOrganizador"]);
			Route::get('/exportar-organizadores', [AdminController::class, "exportarOrganizadores"])->name('exportar-organizadores');
			Route::get('/add-ponente', [AdminController::class, "getAddPonente"])->name('add-ponente');
			Route::post('/add-ponente', [AdminController::class, "postAddPonente"]);
			Route::get('/certificados', [AdminController::class, "certificados"])->name('admin-certificados');
			Route::get('/certificados/organizadores', [AdminController::class, "generarCertificadoOrganizadores"])->name('generar-organizadores');
			Route::get('/certificados/ponentes', [AdminController::class, "generarCertificadoPonentes"])->name('generar-ponentes');
		});
	});
});
Route::get('/certificado/{certificado_id}', [AdminController::class, "documento"])->name('documento');