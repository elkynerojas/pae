<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inventario extends Model
{
    use HasFactory;

    protected $fillable = [
        'producto_id',
        'cantidad_stock',
        'cantidad_minima',
        'precio_unitario',
        'observaciones',
        'activo',
    ];

    protected $casts = [
        'cantidad_stock' => 'integer',
        'cantidad_minima' => 'integer',
        'precio_unitario' => 'decimal:2',
        'activo' => 'boolean',
    ];

    /**
     * Relación con producto
     */
    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class);
    }

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

    /**
     * Scope para obtener productos con stock bajo
     */
    public function scopeStockBajo($query)
    {
        return $query->whereColumn('cantidad_stock', '<=', 'cantidad_minima');
    }

    /**
     * Actualizar stock de un producto
     */
    public static function actualizarStock($productoId, $cantidad, $operacion = 'sumar')
    {
        $inventario = self::firstOrCreate(
            ['producto_id' => $productoId],
            [
                'cantidad_stock' => 0,
                'cantidad_minima' => 0,
                'activo' => true,
            ]
        );

        if ($operacion === 'sumar') {
            $inventario->cantidad_stock += $cantidad;
        } elseif ($operacion === 'restar') {
            $inventario->cantidad_stock -= $cantidad;
            // No permitir stock negativo
            if ($inventario->cantidad_stock < 0) {
                $inventario->cantidad_stock = 0;
            }
        }

        $inventario->save();
        return $inventario;
    }

    /**
     * Actualizar inventario basado en una entrega
     */
    public static function actualizarInventarioPorEntrega($entrega, $operacion = 'sumar')
    {
        $racion = $entrega->racion;
        if (!$racion) {
            return;
        }

        $productosPorRacion = $racion->productosPorRacion;
        $totalBeneficiarios = $entrega->beneficiariosPorEntrega()->sum('cantidad_raciones');
        
        if ($totalBeneficiarios <= 0) {
            return;
        }

        foreach ($productosPorRacion as $productoPorRacion) {
            $cantidadTotal = $productoPorRacion->cantidad * $totalBeneficiarios;
            
            self::actualizarStock(
                $productoPorRacion->producto_id,
                $cantidadTotal,
                $operacion
            );
        }
    }

    /**
     * Revertir inventario de la ración anterior
     */
    public static function revertirInventarioAnterior($entrega)
    {
        $racionAnteriorId = $entrega->getOriginal('racion_id');
        
        if (!$racionAnteriorId) {
            return;
        }

        $racionAnterior = \App\Models\Racion::find($racionAnteriorId);
        if (!$racionAnterior) {
            return;
        }

        $totalBeneficiarios = $entrega->beneficiariosPorEntrega()->sum('cantidad_raciones');
        
        if ($totalBeneficiarios <= 0) {
            return;
        }

        $productosPorRacion = $racionAnterior->productosPorRacion;
        
        foreach ($productosPorRacion as $productoPorRacion) {
            $cantidadTotal = $productoPorRacion->cantidad * $totalBeneficiarios;
            
            self::actualizarStock(
                $productoPorRacion->producto_id,
                $cantidadTotal,
                'restar'
            );
        }
    }

    /**
     * Actualizar inventario basado en un beneficiario específico
     */
    public static function actualizarInventarioPorBeneficiario($beneficiarioPorEntrega, $operacion, $cantidadRaciones = null)
    {
        $entrega = $beneficiarioPorEntrega->entrega;
        if (!$entrega) {
            return;
        }

        $racion = $entrega->racion;
        if (!$racion) {
            return;
        }

        $cantidadARestar = $cantidadRaciones ?? $beneficiarioPorEntrega->cantidad_raciones;
        
        if ($cantidadARestar <= 0) {
            return;
        }

        $productosPorRacion = $racion->productosPorRacion;

        foreach ($productosPorRacion as $productoPorRacion) {
            $cantidadTotal = $productoPorRacion->cantidad * $cantidadARestar;
            
            self::actualizarStock(
                $productoPorRacion->producto_id,
                $cantidadTotal,
                $operacion
            );
        }
    }

    /**
     * Actualizar inventario basado en una recepción
     */
    public static function actualizarInventarioPorRecepcion($recepcion, $operacion = 'sumar')
    {
        $productosPorRecepcion = $recepcion->productosPorRecepcion;
        
        if ($productosPorRecepcion->count() <= 0) {
            return;
        }

        foreach ($productosPorRecepcion as $productoPorRecepcion) {
            self::actualizarStock(
                $productoPorRecepcion->producto_id,
                $productoPorRecepcion->cantidad,
                $operacion
            );
        }
    }
}
