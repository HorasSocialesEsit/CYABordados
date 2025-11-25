<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenPago extends Model
{
    use HasFactory;

    protected $table = 'orden_pagos';

    protected $fillable = [
        'monto',
        'metodo',
        'fecha_pago',
        'nota',
        'saldo_restante',
        'orden_id',
        'usuario_id',
        'tipo_pago_id',
    ];

    public function tipoPago()
    {
        return $this->belongsTo(TipoPago::class, 'tipo_pago_id');
    }


    public function orden()
    {
        return $this->belongsTo(Orden::class, 'orden_id');
    }
}
