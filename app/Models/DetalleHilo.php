<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleHilo extends Model
{
    use HasFactory;

    protected $table = 'detalle_hilos';

    protected $fillable = [
        'cantidad',
        'orden_detalle_id',
        'material_id',
    ];

    // Relación con el detalle de orden
    public function detalle()
    {
        return $this->belongsTo(OrdenDetalle::class, 'orden_detalle_id');
    }

    // Relación con el hilo
    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }
}
