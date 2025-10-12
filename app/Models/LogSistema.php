<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogSistema extends Model
{
    use HasFactory;

    protected $table = 'logs_sistema';

    protected $fillable = [
        'accion',
        'tabla',
        'registro_id',
        'datos_anteriores',
        'datos_nuevos',
        'descripcion',
        'ip_address',
        'user_agent',
        'usuario_id',
    ];

    protected $casts = [
        'datos_anteriores' => 'array',
        'datos_nuevos' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relación con el usuario que realizó la acción
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Scope para filtrar por acción
     */
    public function scopeAccion($query, string $accion)
    {
        return $query->where('accion', $accion);
    }

    /**
     * Scope para filtrar por tabla
     */
    public function scopeTabla($query, string $tabla)
    {
        return $query->where('tabla', $tabla);
    }

    /**
     * Scope para filtrar por usuario
     */
    public function scopeUsuario($query, int $usuarioId)
    {
        return $query->where('usuario_id', $usuarioId);
    }

    /**
     * Scope para filtrar por rango de fechas
     */
    public function scopeRangoFechas($query, $fechaInicio, $fechaFin)
    {
        return $query->whereBetween('created_at', [$fechaInicio, $fechaFin]);
    }

    /**
     * Accessor para obtener el nombre de la acción formateado
     */
    public function getAccionFormateadaAttribute(): string
    {
        return match ($this->accion) {
            'CREATE' => 'Crear',
            'UPDATE' => 'Actualizar',
            'DELETE' => 'Eliminar',
            'LOGIN' => 'Iniciar Sesión',
            'LOGOUT' => 'Cerrar Sesión',
            'EXPORT' => 'Exportar',
            'IMPORT' => 'Importar',
            'CLOSE_DELIVERY' => 'Cerrar Entrega',
            'OPEN_DELIVERY' => 'Abrir Entrega',
            'CLOSE_RECEPTION' => 'Cerrar Recepción',
            'OPEN_RECEPTION' => 'Abrir Recepción',
            default => $this->accion,
        };
    }

    /**
     * Accessor para obtener el color de la acción
     */
    public function getColorAccionAttribute(): string
    {
        return match ($this->accion) {
            'CREATE' => 'success',
            'UPDATE' => 'warning',
            'DELETE' => 'danger',
            'LOGIN' => 'info',
            'LOGOUT' => 'gray',
            'EXPORT' => 'primary',
            'IMPORT' => 'secondary',
            'CLOSE_DELIVERY', 'CLOSE_RECEPTION' => 'danger',
            'OPEN_DELIVERY', 'OPEN_RECEPTION' => 'success',
            default => 'gray',
        };
    }

    /**
     * Accessor para obtener la descripción completa
     */
    public function getDescripcionCompletaAttribute(): string
    {
        $descripcion = $this->descripcion;
        
        if ($this->tabla && $this->registro_id) {
            $descripcion .= " (Tabla: {$this->tabla}, ID: {$this->registro_id})";
        }
        
        if ($this->usuario) {
            $descripcion .= " - Usuario: {$this->usuario->name}";
        }
        
        return $descripcion;
    }
}
