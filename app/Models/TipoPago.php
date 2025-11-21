<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoPago extends Model
{
    protected $table = 'tipo_pago';

    protected $fillable = ['nombre_tipo_pago'];

    public function ordenPagos()
    {
        return $this->hasMany(OrdenPago::class, 'tipo_pago_id');
    }
}
