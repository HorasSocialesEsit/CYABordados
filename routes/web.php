<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\Componentes;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\OrdenesController;
use App\Http\Controllers\OrdenProduccionController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\ProduccionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing.index');
})->name('landing')->middleware('guest');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.post')->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('index.dashboardGeneral')->middleware(['auth', 'active']); // <- aquí agregas middleware

// ////// Ordenes //////
Route::prefix('recepcion')->middleware(['auth', 'active', 'role:recepcion,admin'])->group(function () {
    Route::get('/ordenes', [OrdenesController::class, 'index'])->name('ordenes.index');
    Route::get('/ordenes/crear', [OrdenesController::class, 'create'])->name('ordenes.create');
    Route::post('/ordenes', [OrdenesController::class, 'store'])->name('ordenes.store');
    Route::get('/ordenes/{id}', [OrdenesController::class, 'show'])->name('ordenes.show');
    Route::get('/ordenes/{id}/editar', [OrdenesController::class, 'edit'])->name('ordenes.edit');
    Route::put('/ordenes/{id}', [OrdenesController::class, 'update'])->name('ordenes.update');
    Route::delete('/ordenes{id}', [OrdenesController::class, 'destroy'])->name('ordenes.destroy');
    Route::get('/ordenes/{id}/reporte', [OrdenesController::class, 'reporteOrden'])->name('ordenes.reporteOrden');
    Route::get('/ordenes/{id}/reporte/disehno', [OrdenesController::class, 'reporteOrdenDisehno'])->name('ordenes.reporteOrdenDisehno');
});

// ////// administracion usuarios   ///////////
Route::prefix('administracion-usuarios')->middleware(['auth', 'active', 'role:admin'])->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('usuarios.index');
});

// ////// administracion inventario   ///////////
Route::prefix('administracion-inventario')->middleware(['auth', 'active', 'role:admin'])->group(function () {
    Route::get('/', [InventarioController::class, 'index'])->name('inventario.index');
    Route::get('/inventario/create', [InventarioController::class, 'create'])->name('inventario.create');
    Route::post('/inventario/store', [InventarioController::class, 'store'])->name('inventario.store');
    Route::get('/inventario/{id}/edit', [InventarioController::class, 'edit'])->name('inventario.edit');
    Route::put('/inventario/{id}/update', [InventarioController::class, 'update'])->name('inventario.update');
    Route::delete('inventario/{id}/destroy', [InventarioController::class, 'destroy'])->name('inventario.destroy');
    Route::get('inventario/reporte', [InventarioController::class, 'reporte'])->name('inventario.reporte');
});

Route::middleware(['auth', 'active', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class);
});

Route::prefix('perfil')->middleware(['auth', 'active'])->group(function () {
    Route::get('/', [PerfilController::class, 'index'])->name('perfil');
    Route::put('/', [PerfilController::class, 'update'])->name('perfil.update');
});

Route::prefix('clientes')->middleware(['auth', 'active', 'role:admin'])->group(function () {
    Route::get('/', [ClienteController::class, 'index'])->name('clientes.index');
    Route::get('/crear', [ClienteController::class, 'create'])->name('clientes.create');
    Route::post('/', [ClienteController::class, 'store'])->name('clientes.store');
    Route::get('/{id}/editar', [ClienteController::class, 'edit'])->name('clientes.edit');
    Route::put('/{id}', [ClienteController::class, 'update'])->name('clientes.update');
    Route::delete('/{id}', [ClienteController::class, 'destroy'])->name('clientes.destroy');
});

Route::prefix('produccion')->middleware(['auth', 'active', 'role:admin'])->group(function () {
    Route::get('/', [ProduccionController::class, 'index'])->name('produccion.arte.index');
    Route::get('/crear', [ProduccionController::class, 'create'])->name('Produccion.arte.create');
    Route::get('/{id}/editar', [ProduccionController::class, 'edit'])->name('produccion.arte.edit');
    
   

});
Route::prefix('ordenProceso')->middleware(['auth', 'active', 'role:admin'])->group(function () {
    // rutas de menu orden en proceso
    Route::get('/', [OrdenProduccionController::class, 'index'])->name('ordenProceso.index');
    Route::put('/ordenProceso/{id}/inicio/{estado}', [OrdenProduccionController::class, 'iniciarProceso'])->name('ordenProceso.inicio');
    Route::get('/ordenProceso/{id}/edit', [OrdenProduccionController::class, 'edit'])->name('ordenProceso.edit');
    Route::put('/ordenProceso/{id}/update', [OrdenProduccionController::class, 'update'])->name('ordenProceso.update');

});


// rutas libres
Route::get('/municipios/{id}', [Componentes::class, 'getMunicipiosDepartamento']);
