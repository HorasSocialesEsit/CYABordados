<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    use HasFactory;

    protected $table = 'ordenes';

    protected $fillable = [
        'cliente_id',
        'fecha_orden',
        'codigo_orden',
        'fecha_entrega',
        'estado',
        'tipo',
        'subtotal',
        'impuestos',
        'total',
        'usuario_id',
        'notas',
    ];

    protected $attributes = [
        'estado' => 'pendiente',
        'tipo' => 'venta',
    ];

    /**
     * 🔹 Relaciones
     */

    // Una orden pertenece a un cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    // Una orden pertenece al usuario que la registró
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // Una orden puede tener muchos detalles (productos, artes, materiales, etc.)
    public function detalles()
    {
        return $this->hasMany(OrdenDetalle::class);
    }

    // Una orden puede tener muchas imágenes de arte (si implementas esa tabla)
    public function imagenes()
    {
        return $this->hasMany(OrdenArteImagen::class);
    }

    /**
     * 🔹 Accessors y helpers
     */

    // Mostrar el código formateado
    public function getCodigoFormateadoAttribute()
    {
        return strtoupper($this->codigo_orden);
    }

    // Calcular total automáticamente si quieres manejarlo en el modelo
    public function actualizarTotales()
    {
        $subtotal = $this->detalles->sum(function ($detalle) {
            return $detalle->cantidad * $detalle->precio_unitario;
        });

        $this->subtotal = $subtotal;
        $this->impuestos = $subtotal * 0.13; // IVA 13%
        $this->total = $this->subtotal + $this->impuestos;
        $this->save();
    }
}
