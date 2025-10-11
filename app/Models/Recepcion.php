<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Recepcion extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha',
        'hora',
        'usuario_id',
        'observaciones',
    ];

    protected $casts = [
        'fecha' => 'date',
        'hora' => 'datetime:H:i:s',
    ];

    /**
     * Relación con usuario
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación muchos a muchos con productos
     */
    public function productos(): BelongsToMany
    {
        return $this->belongsToMany(Producto::class, 'productos_por_recepcion')
                    ->withPivot('cantidad')
                    ->withTimestamps();
    }

    /**
     * Relación con productos por recepción
     */
    public function productosPorRecepcion(): HasMany
    {
        return $this->hasMany(\App\Models\ProductoPorRecepcion::class);
    }

    /**
     * Scope para obtener recepciones por fecha
     */
    public function scopePorFecha($query, $fecha)
    {
        return $query->whereDate('fecha', $fecha);
    }

    /**
     * Scope para obtener recepciones por usuario
     */
    public function scopePorUsuario($query, $usuarioId)
    {
        return $query->where('usuario_id', $usuarioId);
    }
}
