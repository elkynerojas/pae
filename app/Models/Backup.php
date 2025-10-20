<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Backup extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'archivo',
        'ruta',
        'tamaño',
        'tamaño_formateado',
        'descripcion',
        'estado',
        'tipo',
        'fecha_creacion',
        'fecha_restauracion',
        'usuario_id',
        'usuario_restauracion_id',
        'notas',
    ];

    protected $casts = [
        'fecha_creacion' => 'datetime',
        'fecha_restauracion' => 'datetime',
        'tamaño' => 'integer',
    ];

    // Relaciones
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function usuarioRestauracion(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_restauracion_id');
    }

    // Scopes
    public function scopeCompletados($query)
    {
        return $query->where('estado', 'completado');
    }

    public function scopeFallidos($query)
    {
        return $query->where('estado', 'fallido');
    }

    public function scopeManuales($query)
    {
        return $query->where('tipo', 'manual');
    }

    public function scopeAutomaticos($query)
    {
        return $query->where('tipo', 'automatico');
    }

    public function scopeProgramados($query)
    {
        return $query->where('tipo', 'programado');
    }

    public function scopeRecientes($query, $dias = 30)
    {
        return $query->where('fecha_creacion', '>=', Carbon::now()->subDays($dias));
    }

    // Accessors
    public function getEstadoColorAttribute(): string
    {
        return match($this->estado) {
            'completado' => 'success',
            'en_proceso' => 'warning',
            'fallido' => 'danger',
            default => 'gray',
        };
    }

    public function getTipoColorAttribute(): string
    {
        return match($this->tipo) {
            'manual' => 'primary',
            'automatico' => 'info',
            'programado' => 'secondary',
            default => 'gray',
        };
    }

    public function getTiempoTranscurridoAttribute(): string
    {
        return $this->fecha_creacion->diffForHumans();
    }

    public function getArchivoExisteAttribute(): bool
    {
        return file_exists($this->ruta);
    }

    // Métodos
    public function puedeRestaurar(): bool
    {
        return $this->estado === 'completado' && $this->archivo_existe;
    }

    public function puedeEliminar(): bool
    {
        return $this->estado !== 'en_proceso';
    }

    public function marcarComoRestaurado($usuarioId = null): void
    {
        $this->update([
            'fecha_restauracion' => now(),
            'usuario_restauracion_id' => $usuarioId ?? auth()->id(),
        ]);
    }

    public function eliminarArchivo(): bool
    {
        if ($this->archivo_existe) {
            return unlink($this->ruta);
        }
        return false;
    }

    public static function crearBackup($nombre, $descripcion = null, $tipo = 'manual'): self
    {
        return self::create([
            'nombre' => $nombre,
            'archivo' => $nombre . '.sql',
            'ruta' => storage_path('app/backups/' . $nombre . '.sql'),
            'tamaño' => 0,
            'tamaño_formateado' => '0 B',
            'descripcion' => $descripcion,
            'estado' => 'en_proceso',
            'tipo' => $tipo,
            'fecha_creacion' => now(),
            'usuario_id' => auth()->id(),
        ]);
    }

    public static function obtenerEstadisticas(): array
    {
        try {
            // Verificar si la tabla existe
            if (!\Schema::hasTable('backups')) {
                return self::obtenerEstadisticasDesdeArchivo();
            }

            $total = self::count();
            $completados = self::completados()->count();
            $fallidos = self::fallidos()->count();
            $tamañoTotal = self::completados()->sum('tamaño');
            $recientes = self::recientes(7)->count();

            return [
                'total' => $total,
                'completados' => $completados,
                'fallidos' => $fallidos,
                'tamaño_total' => $tamañoTotal,
                'tamaño_total_formateado' => self::formatearBytes($tamañoTotal),
                'recientes' => $recientes,
                'porcentaje_exito' => $total > 0 ? round(($completados / $total) * 100, 2) : 0,
            ];
        } catch (\Exception $e) {
            return self::obtenerEstadisticasDesdeArchivo();
        }
    }

    private static function obtenerEstadisticasDesdeArchivo(): array
    {
        $backupInfoPath = storage_path('app/backups/backups_info.json');
        
        if (!file_exists($backupInfoPath)) {
            return [
                'total' => 0,
                'completados' => 0,
                'fallidos' => 0,
                'tamaño_total' => 0,
                'tamaño_total_formateado' => '0 B',
                'recientes' => 0,
                'porcentaje_exito' => 0,
            ];
        }

        $backups = json_decode(file_get_contents($backupInfoPath), true) ?? [];
        
        $total = count($backups);
        $completados = count(array_filter($backups, fn($b) => $b['estado'] === 'completado'));
        $fallidos = count(array_filter($backups, fn($b) => $b['estado'] === 'fallido'));
        $tamañoTotal = array_sum(array_column($backups, 'tamaño'));
        $recientes = count(array_filter($backups, function($b) {
            return Carbon::parse($b['fecha_creacion'])->gte(Carbon::now()->subDays(7));
        }));

        return [
            'total' => $total,
            'completados' => $completados,
            'fallidos' => $fallidos,
            'tamaño_total' => $tamañoTotal,
            'tamaño_total_formateado' => self::formatearBytes($tamañoTotal),
            'recientes' => $recientes,
            'porcentaje_exito' => $total > 0 ? round(($completados / $total) * 100, 2) : 0,
        ];
    }

    private static function formatearBytes($size, $precision = 2): string
    {
        if ($size == 0) return '0 B';
        
        $base = log($size, 1024);
        $suffixes = ['B', 'KB', 'MB', 'GB', 'TB'];
        return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
    }
}
