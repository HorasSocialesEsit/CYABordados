<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenDetalleImagen extends Model
{
    use HasFactory;

    protected $table = 'orden_detalle_imagenes';

    protected $fillable = [
        'ruta_imagen',
        'descripcion',
        'orden_detalle_id',
    ];

    /**
     * 🔹 Relaciones
     */

    // Cada imagen pertenece a un detalle de orden
    public function ordenDetalle()
    {
        return $this->belongsTo(OrdenDetalle::class, 'orden_detalle_id');
    }

    /**
     * 🔹 Accesores / Mutadores útiles
     */

    // Devuelve la URL pública si las imágenes están en storage
    public function getUrlImagenAttribute()
    {
        return asset('storage/' . $this->ruta_imagen);
    }
}


