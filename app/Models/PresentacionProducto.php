<?php

namespace App\Models;

use App\Traits\HasReferentialIntegrity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PresentacionProducto extends Model
{
    use HasFactory, HasReferentialIntegrity;

    protected $table = 'presentaciones_productos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    /**
     * Relación con productos
     */
    public function productos(): HasMany
    {
        return $this->hasMany(Producto::class, 'presentacion_producto_id');
    }

    /**
     * Scope para obtener solo presentaciones activas
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }
}
