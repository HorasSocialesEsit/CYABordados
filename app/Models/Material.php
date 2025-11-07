<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    // nombre de la tabla
    protected $table = 'materiales';

    // campos que se pueden editar
    protected $fillable = [
        'nombre',
        'codigo',
        'descripcion',
        'stock',
        'tipoHilo',
    ];

    public function ordenDetalles()
    {
        return $this->hasMany(OrdenDetalle::class);
    }

    public function detallesHilo()
    {
        return $this->hasMany(DetalleHilo::class, 'material_id');
    }
}
