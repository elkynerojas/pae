<?php

namespace App\Http\Controllers;

use App\Models\Backup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class BackupController extends Controller
{
    public function index()
    {
        $backups = Backup::with(['usuario', 'usuarioRestauracion'])
            ->orderBy('fecha_creacion', 'desc')
            ->paginate(15);

        $estadisticas = Backup::obtenerEstadisticas();

        return view('backups.index', compact('backups', 'estadisticas'));
    }

    public function create()
    {
        return view('backups.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:backups,nombre',
            'descripcion' => 'nullable|string|max:500',
        ]);

        try {
            // Crear registro del backup
            $backup = Backup::crearBackup(
                $request->nombre,
                $request->descripcion,
                'manual'
            );

            // Ejecutar comando de backup
            $exitCode = Artisan::call('backup:database', [
                '--name' => $request->nombre,
                '--description' => $request->descripcion,
            ]);

            if ($exitCode === 0) {
                // Actualizar información del backup
                $archivoPath = storage_path('app/backups/' . $request->nombre . '.sql');
                if (file_exists($archivoPath)) {
                    $tamaño = filesize($archivoPath);
                    $backup->update([
                        'tamaño' => $tamaño,
                        'tamaño_formateado' => $this->formatearBytes($tamaño),
                        'estado' => 'completado',
                    ]);
                }

                return redirect()->route('backups.index')
                    ->with('success', 'Backup creado exitosamente.');
            } else {
                $backup->update(['estado' => 'fallido']);
                return redirect()->back()
                    ->with('error', 'Error al crear el backup. Verifique los logs.');
            }

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function show(Backup $backup)
    {
        $backup->load(['usuario', 'usuarioRestauracion']);
        return view('backups.show', compact('backup'));
    }

    public function download(Backup $backup)
    {
        if (!$backup->archivo_existe) {
            return redirect()->back()
                ->with('error', 'El archivo de backup no existe.');
        }

        return response()->download($backup->ruta, $backup->archivo);
    }

    public function restore(Backup $backup)
    {
        if (!$backup->puedeRestaurar()) {
            return redirect()->back()
                ->with('error', 'No se puede restaurar este backup.');
        }

        try {
            // Obtener configuración de la base de datos
            $connection = DB::connection();
            $database = $connection->getDatabaseName();
            $host = $connection->getConfig('host');
            $port = $connection->getConfig('port');
            $username = $connection->getConfig('username');
            $password = $connection->getConfig('password');

            // Comando mysql para restaurar
            $command = sprintf(
                'mysql --host=%s --port=%s --user=%s --password=%s %s < %s',
                escapeshellarg($host),
                escapeshellarg($port),
                escapeshellarg($username),
                escapeshellarg($password),
                escapeshellarg($database),
                escapeshellarg($backup->ruta)
            );

            // Ejecutar comando
            $returnCode = 0;
            $output = [];
            exec($command, $output, $returnCode);

            if ($returnCode === 0) {
                $backup->marcarComoRestaurado();
                return redirect()->route('backups.index')
                    ->with('success', 'Backup restaurado exitosamente.');
            } else {
                return redirect()->back()
                    ->with('error', 'Error al restaurar el backup. Código de retorno: ' . $returnCode);
            }

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function destroy(Backup $backup)
    {
        if (!$backup->puedeEliminar()) {
            return redirect()->back()
                ->with('error', 'No se puede eliminar este backup.');
        }

        try {
            // Eliminar archivo físico
            if ($backup->archivo_existe) {
                $backup->eliminarArchivo();
            }

            // Eliminar registro
            $backup->delete();

            return redirect()->route('backups.index')
                ->with('success', 'Backup eliminado exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al eliminar el backup: ' . $e->getMessage());
        }
    }

    public function limpiarAntiguos()
    {
        try {
            $dias = request('dias', 30);
            $fechaLimite = Carbon::now()->subDays($dias);

            $backupsAntiguos = Backup::where('fecha_creacion', '<', $fechaLimite)
                ->where('estado', 'completado')
                ->get();

            $eliminados = 0;
            foreach ($backupsAntiguos as $backup) {
                if ($backup->eliminarArchivo()) {
                    $backup->delete();
                    $eliminados++;
                }
            }

            return redirect()->route('backups.index')
                ->with('success', "Se eliminaron {$eliminados} backups antiguos.");

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al limpiar backups antiguos: ' . $e->getMessage());
        }
    }

    public function estadisticas()
    {
        $estadisticas = Backup::obtenerEstadisticas();
        
        // Backups por mes (últimos 12 meses)
        $backupsPorMes = Backup::selectRaw('DATE_FORMAT(fecha_creacion, "%Y-%m") as mes, COUNT(*) as total')
            ->where('fecha_creacion', '>=', Carbon::now()->subMonths(12))
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        // Backups por tipo
        $backupsPorTipo = Backup::selectRaw('tipo, COUNT(*) as total')
            ->groupBy('tipo')
            ->get();

        return response()->json([
            'estadisticas' => $estadisticas,
            'backups_por_mes' => $backupsPorMes,
            'backups_por_tipo' => $backupsPorTipo,
        ]);
    }

    private function formatearBytes($size, $precision = 2): string
    {
        if ($size == 0) return '0 B';
        
        $base = log($size, 1024);
        $suffixes = ['B', 'KB', 'MB', 'GB', 'TB'];
        return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
    }
}
