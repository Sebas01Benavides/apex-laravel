<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\CotizacionController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\CatalogoTecnicoController;

// Rutas de Autenticación
Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Rutas Protegidas
Route::middleware('auth')->group(function () {
    
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Exportaciones a Excel
    Route::get('productos-export-excel', [ProductoController::class, 'exportExcel'])->name('productos.excel');
    Route::get('clientes-export-excel', [ClienteController::class, 'exportExcel'])->name('clientes.excel');
    Route::get('pedidos-export-excel', [PedidoController::class, 'exportExcel'])->name('pedidos.excel');

    // Cotizaciones a Pedidos
    Route::post('cotizaciones/{cotizacion}/convertir', [CotizacionController::class, 'convertirAPedido'])->name('cotizaciones.convertir');

    // Catálogo Técnico
    Route::get('productos/{producto}/catalogo', [CatalogoTecnicoController::class, 'show'])->name('catalogo.show');
    Route::post('productos/{producto}/equivalencia', [CatalogoTecnicoController::class, 'storeEquivalencia'])->name('catalogo.equivalencia.store');
    Route::delete('equivalencias/{equivalencia}', [CatalogoTecnicoController::class, 'destroyEquivalencia'])->name('catalogo.equivalencia.destroy');
    Route::post('productos/{producto}/aplicacion', [CatalogoTecnicoController::class, 'storeAplicacion'])->name('catalogo.aplicacion.store');
    Route::delete('aplicaciones/{aplicacion}', [CatalogoTecnicoController::class, 'destroyAplicacion'])->name('catalogo.aplicacion.destroy');

    // Módulos CRUD
    Route::resource('clientes', ClienteController::class);
    Route::resource('productos', ProductoController::class);
    Route::resource('pedidos', PedidoController::class);
    Route::resource('cotizaciones', CotizacionController::class);
    Route::resource('facturas', FacturaController::class);
});