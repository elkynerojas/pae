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

    protected $table = 'recepciones';

    protected $fillable = [
        'fecha',
        'hora',
        'usuario_id',
        'observaciones',
        'estado',
    ];

    protected $casts = [
        'fecha' => 'date',
        'hora' => 'datetime:H:i:s',
    ];

    protected static function booted()
    {
        static::creating(function ($recepcion) {
            if (empty($recepcion->estado)) {
                $recepcion->estado = 'abierta';
            }
        });

        static::created(function ($recepcion) {
            // No actualizar inventario aquí - se hará cuando se agreguen productos
            // \App\Models\Inventario::actualizarInventarioPorRecepcion($recepcion, 'sumar');
        });

        static::updated(function ($recepcion) {
            // Actualizar inventario si es necesario
        });

        static::deleted(function ($recepcion) {
            // No actualizar inventario aquí - se hará cuando se eliminen productos
            // \App\Models\Inventario::actualizarInventarioPorRecepcion($recepcion, 'restar');
        });
    }

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

    /**
     * Scope para obtener recepciones abiertas
     */
    public function scopeAbiertas($query)
    {
        return $query->where('estado', 'abierta');
    }

    /**
     * Scope para obtener recepciones cerradas
     */
    public function scopeCerradas($query)
    {
        return $query->where('estado', 'cerrada');
    }

    /**
     * Verificar si la recepción está abierta
     */
    public function estaAbierta(): bool
    {
        return $this->estado === 'abierta';
    }

    /**
     * Verificar si la recepción está cerrada
     */
    public function estaCerrada(): bool
    {
        return $this->estado === 'cerrada';
    }

    /**
     * Cerrar la recepción
     */
    public function cerrar(): bool
    {
        if ($this->estaAbierta()) {
            $this->update(['estado' => 'cerrada']);
            return true;
        }
        return false;
    }

    /**
     * Abrir la recepción (NO PERMITIDO - Las recepciones cerradas no se pueden reabrir)
     */
    public function abrir(): bool
    {
        // Las recepciones cerradas no se pueden reabrir
        return false;
    }
}
