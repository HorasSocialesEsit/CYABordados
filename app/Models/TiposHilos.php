<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TiposHilos extends Model
{
  protected $table = 'tipos_hilos';

  protected $fillable = ['nombre_tipo_hilo'];

  public function material()
  {
    return $this->hasMany(Material::class, 'tipo_pago_id');
  }
}
