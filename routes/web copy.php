<?php

use App\Http\Controllers\AlumnosController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Recepcion\RecepcionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotasController;
use App\Http\Controllers\MateriasController;






Route::get('/', function () {
    return view('landing.index');
})->name('landing')->middleware('guest');

Route::get('/consulta-notas', function () {
    return view('app.notas.consultaNotaAlumno');
})->name('consulta.form')->middleware('guest');


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.post')->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('index.dashboardGeneral')->middleware(['auth', 'active']); // <- aquí agregas middleware


//////// consultar notas alumnos   ///////////
Route::prefix('consultarNotas')->group(function () {

    Route::post('/notas/alumno', [NotasController::class, 'notasPorAlumno'])->name('notas.alumnoPublico');
   
});



//////// Recepcion   ///////////
Route::prefix('Recepcion')->middleware(['auth', 'active', 'role:recepcion,admin'])->group(function () {

    Route::get('/', [RecepcionController::class, 'index'])->name('recepcion');
    Route::post('/', [AlumnosController::class, 'store'])->name('alumnos.store');
   
});

//////// alumnos //////
Route::prefix('alumnos')->middleware(['auth', 'active', 'role:recepcion,admin'])->group(function () {
   Route::get('/', [AlumnosController::class, 'index'])->name('alumnos.index');
   Route::get('/alumnos/{carnet}/agregar-materia', [AlumnosController::class, 'agregarMateria'])->name('alumnos.agregarMateria');
   Route::post('/{carnet}/guardar-materia', [AlumnosController::class, 'guardarMateria'])->name('alumnos.guardarMateria');
    Route::get('/alumnos-por-materia', [AlumnosController::class, 'alumnosPorMateria'])->name('alumnos.porMateria');
    Route::get('/alumnos/{carnet}/edit', [AlumnosController::class, 'edit'])->name('alumnos.edit');
Route::put('/alumnos/{carnet}', [AlumnosController::class, 'update'])->name('alumnos.update');

});

//////// Notas   ///////////
Route::prefix('NotasAlumnos')->middleware(['auth', 'active', 'role:recepcion,admin'])->group(function () {

      Route::get('/', [NotasController::class, 'index'])->name('recepcion.notas');
    Route::get('/agregar/{carnet}', [NotasController::class, 'agregarNota'])->name('notas.agregar');
    Route::post('/guardar/{carnet}', [NotasController::class, 'guardarNota'])->name('notas.guardar');
    Route::get('/lista-notas', [NotasController::class, 'listaNotas'])->name('notas.lista');
    Route::post('/notas/alumno', [TuControlador::class, 'notasPorAlumno'])->name('notas.alumno');
    Route::get('/notas/{id}/editar', [NotasController::class, 'editarNota'])->name('notas.editar');
    Route::get('notas/alumno/{carnet}', [NotasController::class, 'notasAlumno'])->name('notas.alumno');


});

//////// Materias   ///////////
Route::prefix('Alumnos-Materias')->middleware(['auth', 'active', 'role:recepcion,admin'])->group(function () {

    Route::get('/', [MateriasController::class, 'index'])->name('materias.index');
});
//////// administracion usuarios   ///////////
Route::prefix('administracion-usuarios')->middleware(['auth', 'active', 'role:admin'])->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('usuarios.index');
});



Route::middleware(['auth', 'active', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class);
});

Route::prefix('perfil')->middleware(['auth', 'active'])->group(function () {
    Route::get('/', [PerfilController::class, 'index'])->name('perfil');
    Route::put('/', [PerfilController::class, 'update'])->name('perfil.update');
});

//////// Precio   ///////////
Route::prefix('Materia-Precios')->middleware(['auth', 'active', 'role:recepcion,admin'])->group(function () {

    Route::get('/', [MateriasController::class, 'index'])->name('materias.index');
});
