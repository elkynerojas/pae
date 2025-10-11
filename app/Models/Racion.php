<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Racion extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    /**
     * Relación muchos a muchos con productos
     */
    public function productos(): BelongsToMany
    {
        return $this->belongsToMany(Producto::class, 'productos_por_racion')
                    ->withPivot('cantidad')
                    ->withTimestamps();
    }

    /**
     * Relación con entregas
     */
    public function entregas(): HasMany
    {
        return $this->hasMany(Entrega::class);
    }

    /**
     * Relación con productos por ración
     */
    public function productosPorRacion(): HasMany
    {
        return $this->hasMany(ProductoPorRacion::class);
    }

    /**
     * Scope para obtener solo raciones activas
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }
}
