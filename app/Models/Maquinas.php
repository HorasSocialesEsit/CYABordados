<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maquinas extends Model
{
    protected $table = 'maquinas';

    // campos que se pueden editar
    protected $fillable = [
        'nombre',
        'cabezales'
    ];
}
