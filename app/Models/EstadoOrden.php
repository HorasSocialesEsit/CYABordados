<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoOrden extends Model
{
    protected $table = 'estado_orden';

    protected $fillable = ['nombre_estado_orden'];

    public function ordenes()
    {
        return $this->hasMany(Orden::class, 'estado_orden_id');
    }
}
