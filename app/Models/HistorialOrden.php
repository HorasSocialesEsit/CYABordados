<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialOrden extends Model
{
    protected $table = 'historial_orden';

    // campos que se pueden editar
    protected $fillable = [
        'cantidad',
        'realizada',
        'restante',
        'orden_id',
    ];

    public function historialOrden()
    {
        return $this->belongsTo(Orden::class, 'orden_id');
    }
}
