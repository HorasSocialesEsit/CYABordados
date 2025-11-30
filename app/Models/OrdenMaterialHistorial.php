<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenMaterialHistorial extends Model
{
    protected $table = 'orden_material_historial';

    protected $fillable = [
        'material_id',
        'orden_id',
        'cantidad',
    ];
}
