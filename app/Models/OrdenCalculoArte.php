<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenCalculoArte extends Model
{
    protected $table = 'ordenes_calculos_por_arte';

    protected $fillable = [
        'orden_id_calculo',
        'arte_id',
        'puntadas',
        'secuencias',
        'rpm',
        'tiempo_ciclo',
        'notaadicional',
        'rutaarte',
    ];

    public function orden()
    {
        return $this->belongsTo(Orden::class, 'orden_id_calculo');
    }

    public function detalle()
    {
        return $this->belongsTo(OrdenDetalle::class, 'arte_id');
    }
}
