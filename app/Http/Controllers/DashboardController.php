<?php

namespace App\Http\Controllers;

use App\Models\Orden;
use Carbon\Carbon;

class DashboardController extends Controller
{
    //
    public function index()
    {

        // Contamos todas las ordenes nuevas
        //  $alumnos = Alumno::withCount('matriculas')->get();
        $ordenesNuevas = Orden::where('estado', 'nueva')->count();
        $ordenesCompletadas = Orden::where('estado', 'completada')->count();
        // $hoy = now()->toDateString();

        $hoy = carbon::today();

        $ordenesAtrazadas = Orden::whereDate('fecha_entrega', '<', $hoy)->count();
        // Para la tarjeta: total de alumnos
        //   $totalAlumnos = $alumnos->count();
        $totalAlumnos = 20;

        // Para la tarjeta: total de matrículas (alumnos matriculados en cursos)
        //  $totalMatriculas = $alumnos->sum('matriculas_count');
        $totalMatriculas = 4;
        // Datos para gráfico: cantidad de alumnos por materia
        //  $materias = Materia::withCount('matriculas')->get();
        $materias = 3;
        $materiaNombres = ['Operador1',
            'Operador2'];
        //  $materiaNombres = $materias->pluck('nombre'); // X
        //  $cantidadAlumnos = $materias->pluck('matriculas_count'); // Y
        $cantidadAlumnos = 10;

        return view('app.dashboardGeneral', compact(
            'totalAlumnos',
            'totalMatriculas',
            'materiaNombres',
            'cantidadAlumnos',
            'ordenesNuevas',
            'ordenesCompletadas',
            'ordenesAtrazadas'

        ));

    }
}
