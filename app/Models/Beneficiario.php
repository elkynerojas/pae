<?php

namespace App\Models;

use App\Traits\HasReferentialIntegrity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Beneficiario extends Model
{
    use HasFactory, HasReferentialIntegrity;

    protected $fillable = [
        'codigo',
        'nombres',
        'apellidos',
        'fecha_nacimiento',
        'genero',
        'grado',
        'grupo',
        'observaciones',
        'activo',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'activo' => 'boolean',
    ];

    /**
     * Relación muchos a muchos con entregas
     */
    public function entregas(): BelongsToMany
    {
        return $this->belongsToMany(Entrega::class, 'beneficiarios_por_entrega')
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
     * Accessor para nombre completo
     */
    public function getNombreCompletoAttribute()
    {
        return $this->nombres . ' ' . $this->apellidos;
    }

    /**
     * Scope para obtener solo beneficiarios activos
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Scope para obtener beneficiarios por grado
     */
    public function scopePorGrado($query, $grado)
    {
        return $query->where('grado', $grado);
    }

    /**
     * Scope para obtener beneficiarios por grupo
     */
    public function scopePorGrupo($query, $grupo)
    {
        return $query->where('grupo', $grupo);
    }

    /**
     * Scope para buscar por código o nombre
     */
    public function scopeBuscar($query, $termino)
    {
        return $query->where('codigo', 'like', "%{$termino}%")
                    ->orWhere('nombres', 'like', "%{$termino}%")
                    ->orWhere('apellidos', 'like', "%{$termino}%");
    }
}
