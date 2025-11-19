<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maquinas extends Model
{
    protected $table = 'maquinas';

    protected $fillable = [
        'nombre',
        'cabezales',
        'rpm'
    ];
}
