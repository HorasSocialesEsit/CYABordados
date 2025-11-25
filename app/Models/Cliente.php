<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    //
    use HasFactory;

    protected $table = 'clientes';
    // Campos que pueden asignarse masivamente (fillable)
    protected $fillable = [
        'nombre',
        'correo',
        'telefono',
        'telefono_alt',
        'direccion',
        'pais',
        'codigo',
        'nit',
        'dui',
        'nrc',
        'estado',
        'id_municipio',
        'tipo_cliente_id',
    ];

    // Valores por defecto (opcional)
    protected $attributes = [
        'pais' => 'El Salvador',
        'estado' => 'Activo',
        // 'tipo_cliente' => 'Persona',
    ];

    public function ordenes()
    {
        return $this->hasMany(Orden::class);
    }
    public function tipoCliente()
    {
        return $this->belongsTo(TipoCliente::class, 'tipo_cliente_id');
    }
}
