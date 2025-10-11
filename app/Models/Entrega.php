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
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

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
