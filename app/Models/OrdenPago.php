<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenPago extends Model
{
    use HasFactory;

    protected $table = 'orden_pagos';

    protected $fillable = [
        'orden_id',
        'monto',
        'tipo',
        'metodo',
        'nota',
        'usuario_id',
        'saldo_restante',
        'fecha_pago',
    ];

    public function orden()
    {
        return $this->belongsTo(Orden::class, 'orden_id');
    }
}
