<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductoPorRacion extends Model
{
    use HasFactory;

    protected $table = 'productos_por_racion';

    protected $fillable = [
        'producto_id',
        'racion_id',
        'cantidad',
    ];

    /**
     * Relación con producto
     */
    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class);
    }

    /**
     * Relación con ración
     */
    public function racion(): BelongsTo
    {
        return $this->belongsTo(Racion::class);
    }
}
