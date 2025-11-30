<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProveedorMaterial extends Model
{
    protected $table = 'proveedor_material';

    protected $fillable = [
        'material_id',
        'proveedor_id',
        'cantidad',
    ];
}
