<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;

    protected $fillable = [
        // Campos específicos del inventario se pueden agregar aquí
        // cuando se complete la migración
    ];

    /**
     * Scope para obtener inventario actual
     */
    public function scopeActual($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Scope para obtener inventario por producto
     */
    public function scopePorProducto($query, $productoId)
    {
        return $query->where('producto_id', $productoId);
    }
}
