<?php

namespace App\Services;

use App\Models\LogSistema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class LogSistemaService
{
    /**
     * Registrar una acción en el log del sistema
     */
    public static function registrar(
        string $accion,
        string $descripcion,
        ?string $tabla = null,
        ?int $registroId = null,
        ?array $datosAnteriores = null,
        ?array $datosNuevos = null
    ): LogSistema {
        return LogSistema::create([
            'accion' => $accion,
            'tabla' => $tabla,
            'registro_id' => $registroId,
            'datos_anteriores' => $datosAnteriores,
            'datos_nuevos' => $datosNuevos,
            'descripcion' => $descripcion,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'usuario_id' => Auth::id(),
        ]);
    }

    /**
     * Registrar creación de registro
     */
    public static function crear(string $tabla, int $registroId, array $datosNuevos, string $descripcion = null): LogSistema
    {
        return self::registrar(
            'CREATE',
            $descripcion ?? "Crear registro en {$tabla}",
            $tabla,
            $registroId,
            null,
            $datosNuevos
        );
    }

    /**
     * Registrar actualización de registro
     */
    public static function actualizar(string $tabla, int $registroId, array $datosAnteriores, array $datosNuevos, string $descripcion = null): LogSistema
    {
        return self::registrar(
            'UPDATE',
            $descripcion ?? "Actualizar registro en {$tabla}",
            $tabla,
            $registroId,
            $datosAnteriores,
            $datosNuevos
        );
    }

    /**
     * Registrar eliminación de registro
     */
    public static function eliminar(string $tabla, int $registroId, array $datosAnteriores, string $descripcion = null): LogSistema
    {
        return self::registrar(
            'DELETE',
            $descripcion ?? "Eliminar registro en {$tabla}",
            $tabla,
            $registroId,
            $datosAnteriores,
            null
        );
    }

    /**
     * Registrar inicio de sesión
     */
    public static function login(int $usuarioId, string $descripcion = null): LogSistema
    {
        return self::registrar(
            'LOGIN',
            $descripcion ?? "Inicio de sesión",
            null,
            $usuarioId,
            null,
            null
        );
    }

    /**
     * Registrar cierre de sesión
     */
    public static function logout(int $usuarioId, string $descripcion = null): LogSistema
    {
        return self::registrar(
            'LOGOUT',
            $descripcion ?? "Cierre de sesión",
            null,
            $usuarioId,
            null,
            null
        );
    }

    /**
     * Registrar exportación
     */
    public static function exportar(string $tipo, string $descripcion = null): LogSistema
    {
        return self::registrar(
            'EXPORT',
            $descripcion ?? "Exportar {$tipo}",
            null,
            null,
            null,
            ['tipo' => $tipo]
        );
    }

    /**
     * Registrar importación
     */
    public static function importar(string $tipo, int $registrosImportados, string $descripcion = null): LogSistema
    {
        return self::registrar(
            'IMPORT',
            $descripcion ?? "Importar {$tipo}",
            null,
            null,
            null,
            ['tipo' => $tipo, 'registros_importados' => $registrosImportados]
        );
    }

    /**
     * Registrar cierre de entrega
     */
    public static function cerrarEntrega(int $entregaId, string $descripcion = null): LogSistema
    {
        return self::registrar(
            'CLOSE_DELIVERY',
            $descripcion ?? "Cerrar entrega",
            'entregas',
            $entregaId,
            null,
            null
        );
    }

    /**
     * Registrar apertura de entrega
     */
    public static function abrirEntrega(int $entregaId, string $descripcion = null): LogSistema
    {
        return self::registrar(
            'OPEN_DELIVERY',
            $descripcion ?? "Abrir entrega",
            'entregas',
            $entregaId,
            null,
            null
        );
    }

    /**
     * Registrar cierre de recepción
     */
    public static function cerrarRecepcion(int $recepcionId, string $descripcion = null): LogSistema
    {
        return self::registrar(
            'CLOSE_RECEPTION',
            $descripcion ?? "Cerrar recepción",
            'recepciones',
            $recepcionId,
            null,
            null
        );
    }

    /**
     * Registrar apertura de recepción
     */
    public static function abrirRecepcion(int $recepcionId, string $descripcion = null): LogSistema
    {
        return self::registrar(
            'OPEN_RECEPTION',
            $descripcion ?? "Abrir recepción",
            'recepciones',
            $recepcionId,
            null,
            null
        );
    }

    /**
     * Obtener estadísticas de actividad
     */
    public static function estadisticas(int $dias = 30): array
    {
        $fechaInicio = now()->subDays($dias);
        
        return [
            'total_acciones' => LogSistema::where('created_at', '>=', $fechaInicio)->count(),
            'acciones_por_tipo' => LogSistema::where('created_at', '>=', $fechaInicio)
                ->selectRaw('accion, COUNT(*) as total')
                ->groupBy('accion')
                ->pluck('total', 'accion')
                ->toArray(),
            'usuarios_activos' => LogSistema::where('created_at', '>=', $fechaInicio)
                ->distinct('usuario_id')
                ->count('usuario_id'),
            'tablas_mas_afectadas' => LogSistema::where('created_at', '>=', $fechaInicio)
                ->whereNotNull('tabla')
                ->selectRaw('tabla, COUNT(*) as total')
                ->groupBy('tabla')
                ->orderByDesc('total')
                ->limit(10)
                ->pluck('total', 'tabla')
                ->toArray(),
        ];
    }
}
