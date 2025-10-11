<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'activo',
        'tipo_producto_id',
        'presentacion_producto_id',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    /**
     * Relación con tipo de producto
     */
    public function tipoProducto(): BelongsTo
    {
        return $this->belongsTo(TipoProducto::class, 'tipo_producto_id');
    }

    /**
     * Relación con presentación de producto
     */
    public function presentacionProducto(): BelongsTo
    {
        return $this->belongsTo(PresentacionProducto::class, 'presentacion_producto_id');
    }

    /**
     * Relación muchos a muchos con raciones
     */
    public function raciones(): BelongsToMany
    {
        return $this->belongsToMany(Racion::class, 'productos_por_racion')
                    ->withPivot('cantidad')
                    ->withTimestamps();
    }

    /**
     * Relación muchos a muchos con recepciones
     */
    public function recepciones(): BelongsToMany
    {
        return $this->belongsToMany(Recepcion::class, 'productos_por_recepcion')
                    ->withPivot('cantidad')
                    ->withTimestamps();
    }

    /**
     * Relación con productos por ración
     */
    public function productosPorRacion(): HasMany
    {
        return $this->hasMany(ProductoPorRacion::class);
    }

    /**
     * Relación con productos por recepción
     */
    public function productosPorRecepcion(): HasMany
    {
        return $this->hasMany(\App\Models\ProductoPorRecepcion::class);
    }

    /**
     * Scope para obtener solo productos activos
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }
}
