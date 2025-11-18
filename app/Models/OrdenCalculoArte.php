<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenCalculoArte extends Model
{
    protected $table = 'ordenes_calculos_por_arte';

    protected $fillable = [
        'orden_id',
        'detalle_id',
        'puntadas',
        'secuencias',
        'rpm',
        'tiempo_ciclo',
        'notas',
        'ruta_arte',
    ];

    public function orden()
    {
        return $this->belongsTo(Orden::class);
    }

    public function detalle()
    {
        return $this->belongsTo(OrdenDetalle::class);
    }
}
