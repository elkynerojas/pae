<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;

class BackupDatabaseDemo extends Command
{
    protected $signature = 'backup:demo {--name=} {--description=}';
    protected $description = 'Crear backup de demostración (sin base de datos)';

    public function handle()
    {
        $this->info('Iniciando backup de demostración...');

        try {
            // Generar nombre del archivo
            $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
            $name = $this->option('name') ?: 'backup_demo_' . $timestamp;
            $filename = $name . '.sql';

            // Crear directorio de backups si no existe
            $backupPath = storage_path('app/backups');
            if (!file_exists($backupPath)) {
                mkdir($backupPath, 0755, true);
            }
            
            // Si no podemos escribir en el directorio, usar temporal
            if (!is_writable($backupPath)) {
                $backupPath = sys_get_temp_dir() . '/pae_backups';
                if (!file_exists($backupPath)) {
                    mkdir($backupPath, 0755, true);
                }
                $this->warn("Usando directorio temporal: {$backupPath}");
            }

            $filepath = $backupPath . '/' . $filename;

            // Crear contenido de backup simulado
            $backupContent = $this->generateDemoBackupContent($name, $this->option('description'));

            // Escribir archivo
            file_put_contents($filepath, $backupContent);

            // Obtener información del archivo
            $fileSize = filesize($filepath);
            $fileSizeFormatted = $this->formatBytes($fileSize);

            // Guardar información del backup en archivo JSON
            $backupInfo = [
                'nombre' => $name,
                'archivo' => $filename,
                'ruta' => $filepath,
                'tamaño' => $fileSize,
                'tamaño_formateado' => $fileSizeFormatted,
                'descripcion' => $this->option('description') ?: 'Backup de demostración',
                'fecha_creacion' => Carbon::now()->toISOString(),
                'estado' => 'completado',
                'tipo' => 'manual',
                'usuario_id' => null,
            ];

            $this->saveBackupInfoToFile($backupInfo);

            $this->info("✅ Backup de demostración creado exitosamente: {$filename}");
            $this->info("📁 Ubicación: {$filepath}");
            $this->info("📊 Tamaño: {$fileSizeFormatted}");
            $this->info("ℹ️  Este es un backup de demostración (sin conexión a base de datos)");

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error('❌ Error al crear backup de demostración: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }

    private function generateDemoBackupContent($name, $description)
    {
        $content = "-- Backup de base de datos: Sistema PAE (Demostración)\n";
        $content .= "-- Generado el: " . now()->format('Y-m-d H:i:s') . "\n";
        $content .= "-- Generado por: Sistema PAE - Módulo de Backup\n";
        $content .= "-- Nombre: {$name}\n";
        $content .= "-- Descripción: {$description}\n\n";
        
        $content .= "SET FOREIGN_KEY_CHECKS = 0;\n\n";

        // Simular estructura de tablas del sistema PAE
        $tables = [
            'users' => [
                'structure' => "CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `apellidos` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `cargo` varchar(255) DEFAULT NULL,
  `rol` enum('admin','gestor','operador') NOT NULL DEFAULT 'operador',
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `ultimo_acceso` timestamp NULL DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
                'data' => [
                    "INSERT INTO `users` (`id`, `name`, `apellidos`, `email`, `rol`, `activo`, `created_at`, `updated_at`) VALUES (1, 'Administrador', 'Sistema', 'admin@pae.edu.co', 'admin', 1, NOW(), NOW());",
                    "INSERT INTO `users` (`id`, `name`, `apellidos`, `email`, `rol`, `activo`, `created_at`, `updated_at`) VALUES (2, 'Gestor', 'Principal', 'gestor@pae.edu.co', 'gestor', 1, NOW(), NOW());"
                ]
            ],
            'beneficiarios' => [
                'structure' => "CREATE TABLE `beneficiarios` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` varchar(255) DEFAULT NULL,
  `nombres` varchar(255) NOT NULL,
  `apellidos` varchar(255) NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `genero` enum('masculino','femenino') NOT NULL,
  `grado` enum('primero','segundo','tercero','cuarto','quinto','sexto','septimo','octavo','noveno','decimo') DEFAULT NULL,
  `grupo` int(11) DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `huella_template` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `beneficiarios_codigo_unique` (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
                'data' => [
                    "INSERT INTO `beneficiarios` (`id`, `codigo`, `nombres`, `apellidos`, `genero`, `grado`, `grupo`, `activo`, `created_at`, `updated_at`) VALUES (1, 'EST-001', 'Juan', 'Pérez', 'masculino', 'primero', 1, 1, NOW(), NOW());",
                    "INSERT INTO `beneficiarios` (`id`, `codigo`, `nombres`, `apellidos`, `genero`, `grado`, `grupo`, `activo`, `created_at`, `updated_at`) VALUES (2, 'EST-002', 'María', 'González', 'femenino', 'segundo', 2, 1, NOW(), NOW());"
                ]
            ],
            'productos' => [
                'structure' => "CREATE TABLE `productos` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `tipo_producto_id` bigint(20) UNSIGNED NOT NULL,
  `presentacion_producto_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `productos_tipo_producto_id_foreign` (`tipo_producto_id`),
  KEY `productos_presentacion_producto_id_foreign` (`presentacion_producto_id`),
  CONSTRAINT `productos_tipo_producto_id_foreign` FOREIGN KEY (`tipo_producto_id`) REFERENCES `tipos_productos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `productos_presentacion_producto_id_foreign` FOREIGN KEY (`presentacion_producto_id`) REFERENCES `presentaciones_productos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
                'data' => [
                    "INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `activo`, `tipo_producto_id`, `presentacion_producto_id`, `created_at`, `updated_at`) VALUES (1, 'Arroz', 'Arroz blanco de primera calidad', 1, 1, 1, NOW(), NOW());",
                    "INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `activo`, `tipo_producto_id`, `presentacion_producto_id`, `created_at`, `updated_at`) VALUES (2, 'Frijoles', 'Frijoles rojos', 1, 1, 1, NOW(), NOW());"
                ]
            ]
        ];

        foreach ($tables as $tableName => $tableData) {
            $content .= "-- Estructura de la tabla `{$tableName}`\n";
            $content .= "DROP TABLE IF EXISTS `{$tableName}`;\n";
            $content .= $tableData['structure'] . "\n\n";

            if (!empty($tableData['data'])) {
                $content .= "-- Datos de la tabla `{$tableName}`\n";
                foreach ($tableData['data'] as $insert) {
                    $content .= $insert . "\n";
                }
                $content .= "\n";
            }
        }

        $content .= "SET FOREIGN_KEY_CHECKS = 1;\n";
        $content .= "-- Fin del backup de demostración\n";

        return $content;
    }

    private function saveBackupInfoToFile($backupInfo)
    {
        // Usar directorio temporal si el original no es escribible
        $backupInfoPath = storage_path('app/backups/backups_info.json');
        if (!is_writable(dirname($backupInfoPath))) {
            $backupInfoPath = sys_get_temp_dir() . '/pae_backups/backups_info.json';
        }
        
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
