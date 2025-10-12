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

    // Los eventos están manejados por BeneficiarioPorEntregaObserver para evitar duplicación

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
