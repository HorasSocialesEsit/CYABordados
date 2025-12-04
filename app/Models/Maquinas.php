<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maquinas extends Model
{
    protected $table = 'maquinas';

    protected $fillable = [
        'nombre',
        'cabezales',
        'cabezales_danado',
        'rpm',
        'en_uso',
    ];

    public function maquinasOrdenDetalle()
    {
        return $this->hasMany(OrdenDetalle::class, 'maquina_id');
    }

    public function calculos()
    {
        return $this->hasMany(OrdenCalculoArte::class, 'maquina_id');
    }
}
