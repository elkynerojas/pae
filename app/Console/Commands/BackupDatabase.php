<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class BackupDatabase extends Command
{
    protected $signature = 'backup:database {--name=} {--description=}';
    protected $description = 'Crear backup de la base de datos';

    public function handle()
    {
        $this->info('Iniciando backup de la base de datos...');

        try {
            // Obtener configuración de la base de datos
            $connection = DB::connection();
            $database = $connection->getDatabaseName();
            $host = $connection->getConfig('host');
            $port = $connection->getConfig('port');
            $username = $connection->getConfig('username');
            $password = $connection->getConfig('password');

            // Generar nombre del archivo
            $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
            $name = $this->option('name') ?: 'backup_' . $timestamp;
            $filename = $name . '.sql';

            // Crear directorio de backups si no existe
            $backupPath = storage_path('app/backups');
            if (!file_exists($backupPath)) {
                mkdir($backupPath, 0755, true);
            }

            $filepath = $backupPath . '/' . $filename;

            // Verificar si mysqldump está disponible
            $mysqldumpPath = '';
            $possiblePaths = [
                '/usr/bin/mysqldump',
                '/usr/local/bin/mysqldump',
                'mysqldump'
            ];

            foreach ($possiblePaths as $path) {
                if (shell_exec("which $path 2>/dev/null")) {
                    $mysqldumpPath = $path;
                    break;
                }
            }

            if (empty($mysqldumpPath)) {
                // Si mysqldump no está disponible, usar PHP para crear el backup
                $this->createBackupWithPHP($connection, $filepath);
            } else {
                // Usar mysqldump si está disponible
                $command = sprintf(
                    '%s --host=%s --port=%s --user=%s --password=%s --single-transaction --routines --triggers %s > %s',
                    escapeshellarg($mysqldumpPath),
                    escapeshellarg($host),
                    escapeshellarg($port),
                    escapeshellarg($username),
                    escapeshellarg($password),
                    escapeshellarg($database),
                    escapeshellarg($filepath)
                );

                // Ejecutar comando
                $returnCode = 0;
                $output = [];
                exec($command, $output, $returnCode);

                if ($returnCode !== 0) {
                    throw new \Exception('Error al ejecutar mysqldump. Código de retorno: ' . $returnCode);
                }
            }

            // Verificar que el archivo se creó
            if (!file_exists($filepath)) {
                throw new \Exception('El archivo de backup no se creó correctamente');
            }

            // Obtener información del archivo
            $fileSize = filesize($filepath);
            $fileSizeFormatted = $this->formatBytes($fileSize);

            // Guardar información del backup en la base de datos
            $backupInfo = [
                'nombre' => $name,
                'archivo' => $filename,
                'ruta' => $filepath,
                'tamaño' => $fileSize,
                'tamaño_formateado' => $fileSizeFormatted,
                'descripcion' => $this->option('description') ?: 'Backup automático',
                'fecha_creacion' => Carbon::now(),
                'estado' => 'completado',
                'usuario_id' => auth()->id() ?? null,
            ];

            // Insertar en tabla de backups (si existe)
            try {
                if (DB::getSchemaBuilder()->hasTable('backups')) {
                    DB::table('backups')->insert($backupInfo);
                } else {
                    // Si la tabla no existe, guardar información en archivo JSON
                    $this->saveBackupInfoToFile($backupInfo);
                }
            } catch (\Exception $e) {
                // Si hay error con la base de datos, guardar en archivo
                $this->saveBackupInfoToFile($backupInfo);
                $this->warn('Información del backup guardada en archivo (tabla no disponible):');
                $this->table(
                    ['Campo', 'Valor'],
                    [
                        ['Nombre', $backupInfo['nombre']],
                        ['Archivo', $backupInfo['archivo']],
                        ['Tamaño', $backupInfo['tamaño_formateado']],
                        ['Descripción', $backupInfo['descripcion']],
                        ['Fecha', $backupInfo['fecha_creacion']->format('Y-m-d H:i:s')],
                    ]
                );
            }

            $this->info("✅ Backup creado exitosamente: {$filename}");
            $this->info("📁 Ubicación: {$filepath}");
            $this->info("📊 Tamaño: {$fileSizeFormatted}");

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error('❌ Error al crear backup: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }

    private function createBackupWithPHP($connection, $filepath)
    {
        $this->info('Creando backup usando PHP (mysqldump no disponible)...');

        $database = $connection->getDatabaseName();
        $backupContent = "-- Backup de base de datos: {$database}\n";
        $backupContent .= "-- Generado el: " . now()->format('Y-m-d H:i:s') . "\n";
        $backupContent .= "-- Generado por: Sistema PAE\n\n";
        $backupContent .= "SET FOREIGN_KEY_CHECKS = 0;\n\n";

        try {
            // Obtener todas las tablas
            $tables = $connection->select("SHOW TABLES");
            $tableColumn = "Tables_in_{$database}";

            foreach ($tables as $table) {
                $tableName = $table->$tableColumn;
                $this->info("Procesando tabla: {$tableName}");

                // Crear estructura de la tabla
                $createTable = $connection->select("SHOW CREATE TABLE `{$tableName}`");
                $backupContent .= "-- Estructura de la tabla `{$tableName}`\n";
                $backupContent .= "DROP TABLE IF EXISTS `{$tableName}`;\n";
                $backupContent .= $createTable[0]->{'Create Table'} . ";\n\n";

                // Obtener datos de la tabla
                $rows = $connection->select("SELECT * FROM `{$tableName}`");
                
                if (!empty($rows)) {
                    $backupContent .= "-- Datos de la tabla `{$tableName}`\n";
                    
                    // Obtener nombres de columnas
                    $columns = array_keys((array) $rows[0]);
                    $columnList = '`' . implode('`, `', $columns) . '`';
                    
                    foreach ($rows as $row) {
                        $values = [];
                        foreach ($row as $value) {
                            if ($value === null) {
                                $values[] = 'NULL';
                            } else {
                                $values[] = "'" . addslashes($value) . "'";
                            }
                        }
                        $backupContent .= "INSERT INTO `{$tableName}` ({$columnList}) VALUES (" . implode(', ', $values) . ");\n";
                    }
                    $backupContent .= "\n";
                }
            }

            $backupContent .= "SET FOREIGN_KEY_CHECKS = 1;\n";

            // Escribir archivo
            file_put_contents($filepath, $backupContent);

            $this->info("✅ Backup creado exitosamente usando PHP");

        } catch (\Exception $e) {
            throw new \Exception('Error al crear backup con PHP: ' . $e->getMessage());
        }
    }

    private function saveBackupInfoToFile($backupInfo)
    {
        $backupInfoPath = storage_path('app/backups/backups_info.json');
        
        // Leer información existente
        $existingInfo = [];
        if (file_exists($backupInfoPath)) {
            $existingInfo = json_decode(file_get_contents($backupInfoPath), true) ?? [];
        }
        
        // Agregar nuevo backup
        $existingInfo[] = $backupInfo;
        
        // Guardar información actualizada
        file_put_contents($backupInfoPath, json_encode($existingInfo, JSON_PRETTY_PRINT));
    }

    private function formatBytes($size, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = ['B', 'KB', 'MB', 'GB', 'TB'];
        return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
    }
}
