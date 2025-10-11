<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BeneficiarioPorEntrega extends Model
{
    use HasFactory;

    protected $table = 'beneficiarios_por_entrega';

    protected $fillable = [
        'beneficiario_id',
        'entrega_id',
        'cantidad_raciones',
        'observaciones',
    ];

    protected static function booted()
    {
        static::created(function ($beneficiarioPorEntrega) {
            \App\Models\Inventario::actualizarInventarioPorBeneficiario($beneficiarioPorEntrega, 'sumar');
        });

        static::updated(function ($beneficiarioPorEntrega) {
            if ($beneficiarioPorEntrega->wasChanged('cantidad_raciones')) {
                $cantidadAnterior = $beneficiarioPorEntrega->getOriginal('cantidad_raciones');
                $cantidadNueva = $beneficiarioPorEntrega->cantidad_raciones;
                $diferencia = $cantidadNueva - $cantidadAnterior;
                
                if ($diferencia > 0) {
                    \App\Models\Inventario::actualizarInventarioPorBeneficiario($beneficiarioPorEntrega, 'sumar', $diferencia);
                } elseif ($diferencia < 0) {
                    \App\Models\Inventario::actualizarInventarioPorBeneficiario($beneficiarioPorEntrega, 'restar', abs($diferencia));
                }
            }
        });

        static::deleted(function ($beneficiarioPorEntrega) {
            \App\Models\Inventario::actualizarInventarioPorBeneficiario($beneficiarioPorEntrega, 'restar');
        });
    }

    /**
     * Relación con beneficiario
     */
    public function beneficiario(): BelongsTo
    {
        return $this->belongsTo(Beneficiario::class);
    }

    /**
     * Relación con entrega
     */
    public function entrega(): BelongsTo
    {
        return $this->belongsTo(Entrega::class);
    }
}
