<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialOrden extends Model
{
    protected $table = 'historial_orden';

    // campos que se pueden editar
    protected $fillable = [
        'rpm',
        'puntadas',
        'secuencias',
        'cabezales',
        'tiempo_cambio',
        'eficiencia',
        'ciclos',
        'horas',
        'minutos',
        'cantidad',
        'realizada',
        'restante',
        'orden_id',
    ];
}
