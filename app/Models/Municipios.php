<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Municipios extends Model
{
    protected $table = 'municipios';
    protected $fillable = [
        'nombre_municipio',
        'id_departamento'
    ];
}
