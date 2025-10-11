<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductoPorRecepcion extends Model
{
    use HasFactory;

    protected $table = 'productos_por_recepcion';

    protected $fillable = [
        'producto_id',
        'recepcion_id',
        'cantidad',
    ];

    protected static function booted()
    {
        static::created(function ($productoPorRecepcion) {
            \App\Models\Inventario::actualizarStock(
                $productoPorRecepcion->producto_id,
                $productoPorRecepcion->cantidad,
                'sumar'
            );
        });

        static::updated(function ($productoPorRecepcion) {
            if ($productoPorRecepcion->wasChanged('cantidad')) {
                $cantidadAnterior = $productoPorRecepcion->getOriginal('cantidad');
                $cantidadNueva = $productoPorRecepcion->cantidad;
                $diferencia = $cantidadNueva - $cantidadAnterior;
                
                if ($diferencia > 0) {
                    \App\Models\Inventario::actualizarStock(
                        $productoPorRecepcion->producto_id,
                        $diferencia,
                        'sumar'
                    );
                } elseif ($diferencia < 0) {
                    \App\Models\Inventario::actualizarStock(
                        $productoPorRecepcion->producto_id,
                        abs($diferencia),
                        'restar'
                    );
                }
            }
        });

        static::deleted(function ($productoPorRecepcion) {
            \App\Models\Inventario::actualizarStock(
                $productoPorRecepcion->producto_id,
                $productoPorRecepcion->cantidad,
                'restar'
            );
        });
    }

    /**
     * Relación con producto
     */
    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class);
    }

    /**
     * Relación con recepción
     */
    public function recepcion(): BelongsTo
    {
        return $this->belongsTo(Recepcion::class);
    }
}
