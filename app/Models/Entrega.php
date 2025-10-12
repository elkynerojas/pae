<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Entrega extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha',
        'racion_id',
        'observaciones',
        'estado',
        'fecha_cierre',
        'usuario_cierre_id',
    ];

    protected $attributes = [
        'estado' => 'abierta',
    ];

    protected $casts = [
        'fecha' => 'date',
        'fecha_cierre' => 'datetime',
    ];

    // Los eventos están manejados por EntregaObserver para evitar duplicación

    /**
     * Relación con ración
     */
    public function racion(): BelongsTo
    {
        return $this->belongsTo(Racion::class);
    }

    /**
     * Relación muchos a muchos con beneficiarios
     */
    public function beneficiarios(): BelongsToMany
    {
        return $this->belongsToMany(Beneficiario::class, 'beneficiarios_por_entrega')
                    ->withPivot('cantidad_raciones', 'observaciones')
                    ->withTimestamps();
    }

    /**
     * Relación con beneficiarios por entrega
     */
    public function beneficiariosPorEntrega(): HasMany
    {
        return $this->hasMany(\App\Models\BeneficiarioPorEntrega::class);
    }

    /**
     * Scope para obtener entregas por fecha
     */
    public function scopePorFecha($query, $fecha)
    {
        return $query->whereDate('fecha', $fecha);
    }

    /**
     * Relación con usuario que cerró la entrega
     */
    public function usuarioCierre(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_cierre_id');
    }

    /**
     * Verificar si la entrega está cerrada
     */
    public function estaCerrada(): bool
    {
        return ($this->estado ?? 'abierta') === 'cerrada';
    }

    /**
     * Verificar si la entrega está abierta
     */
    public function estaAbierta(): bool
    {
        return ($this->estado ?? 'abierta') === 'abierta';
    }

    /**
     * Cerrar la entrega
     */
    public function cerrar(): bool
    {
        if ($this->estaCerrada()) {
            return false; // Ya está cerrada
        }

        $this->update([
            'estado' => 'cerrada',
            'fecha_cierre' => now(),
            'usuario_cierre_id' => auth()->id(),
        ]);

        return true;
    }

    /**
     * Abrir la entrega (solo para administradores)
     */
    public function abrir(): bool
    {
        if ($this->estaAbierta()) {
            return false; // Ya está abierta
        }

        $this->update([
            'estado' => 'abierta',
            'fecha_cierre' => null,
            'usuario_cierre_id' => null,
        ]);

        return true;
    }

    /**
     * Scope para obtener solo entregas abiertas
     */
    public function scopeAbiertas($query)
    {
        return $query->where('estado', 'abierta');
    }

    /**
     * Scope para obtener solo entregas cerradas
     */
    public function scopeCerradas($query)
    {
        return $query->where('estado', 'cerrada');
    }

    /**
     * Scope para obtener entregas por ración
     */
    public function scopePorRacion($query, $racionId)
    {
        return $query->where('racion_id', $racionId);
    }

    /**
     * Scope para obtener entregas de un rango de fechas
     */
    public function scopePorRangoFechas($query, $fechaInicio, $fechaFin)
    {
        return $query->whereBetween('fecha', [$fechaInicio, $fechaFin]);
    }
}
