<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    use HasFactory;

    protected $table = 'ordenes';

    protected $fillable = [
        'fecha_orden',
        'codigo_orden',
        'fecha_entrega',
        'tipo',
        'precio_total',
        'estado_orden_id',
        'cliente_id',
        'usuario_id'
    ];

    protected $casts = [
        'fecha_orden' => 'datetime',
        'fecha_entrega' => 'date',
    ];
    public function estado()
    {
        return $this->belongsTo(EstadoOrden::class, 'estado_orden_id');
    }

    protected $attributes = [
        // 'estado' => 'nueva',
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
        //  return $this->hasMany(OrdenDetalle::class);
        return $this->hasMany(OrdenDetalle::class)->orderBy('id', 'asc');
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

        $this->precio_total = $subtotal;
        //   $this->impuestos = $subtotal * 0.13; // IVA 13%
        // $this->total = $this->subtotal;
        $this->save();
    }

    public function pagos()
    {
        return $this->hasMany(OrdenPago::class, 'orden_id');
    }

    // 🔹 Accesor dinámico para saldo pendiente
    public function getSaldoPendienteAttribute()
    {
        $pagado = $this->pagos->sum('monto');

        return $this->total - $pagado;
    }
}
