<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6">
            <div class="flex items-center space-x-3">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Sistema de Backup</h1>
                    <p class="text-gray-600 dark:text-gray-300">Guía completa para la gestión de respaldos de la base de datos</p>
                </div>
            </div>
        </div>

        <!-- Navegación Rápida -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Navegación Rápida</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="#crear-backup" class="flex items-center p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors">
                    <svg class="h-5 w-5 text-blue-600 dark:text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span class="text-sm font-medium text-blue-600 dark:text-blue-400">Crear Backup</span>
                </a>
                <a href="#gestionar-backups" class="flex items-center p-3 bg-green-50 dark:bg-green-900/20 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/30 transition-colors">
                    <svg class="h-5 w-5 text-green-600 dark:text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <span class="text-sm font-medium text-green-600 dark:text-green-400">Gestionar</span>
                </a>
                <a href="#descargar-backup" class="flex items-center p-3 bg-purple-50 dark:bg-purple-900/20 rounded-lg hover:bg-purple-100 dark:hover:bg-purple-900/30 transition-colors">
                    <svg class="h-5 w-5 text-purple-600 dark:text-purple-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="text-sm font-medium text-purple-600 dark:text-purple-400">Descargar</span>
                </a>
                <a href="#restaurar-backup" class="flex items-center p-3 bg-orange-50 dark:bg-orange-900/20 rounded-lg hover:bg-orange-100 dark:hover:bg-orange-900/30 transition-colors">
                    <svg class="h-5 w-5 text-orange-600 dark:text-orange-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    <span class="text-sm font-medium text-orange-600 dark:text-orange-400">Restaurar</span>
                </a>
            </div>
        </div>

        <!-- Crear Backup -->
        <div id="crear-backup" class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">📦 Crear Backup Manual</h2>
            
            <div class="space-y-4">
                <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700 dark:text-blue-300">
                                <strong>Importante:</strong> Los backups contienen toda la información del sistema. Asegúrate de tener suficiente espacio en disco.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Desde la Interfaz Web</h3>
                        <ol class="list-decimal list-inside space-y-2 text-gray-600 dark:text-gray-300">
                            <li>Navega a <strong>Backup</strong> en el menú lateral</li>
                            <li>Haz clic en <strong>"Crear Backup"</strong></li>
                            <li>Completa los campos:
                                <ul class="list-disc list-inside ml-4 mt-2 space-y-1">
                                    <li><strong>Nombre:</strong> Identificador único del backup</li>
                                    <li><strong>Descripción:</strong> Propósito o motivo del backup</li>
                                </ul>
                            </li>
                            <li>Haz clic en <strong>"Crear Backup"</strong></li>
                            <li>Espera a que se complete el proceso</li>
                        </ol>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Desde Línea de Comandos</h3>
                        <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4">
                            <code class="text-sm text-gray-800 dark:text-gray-200">
                                # Backup manual<br>
                                php artisan backup:database \<br>
                                &nbsp;&nbsp;--name="backup_manual" \<br>
                                &nbsp;&nbsp;--description="Backup antes de actualización"<br><br>
                                
                                # Backup de demostración (sin MySQL)<br>
                                php artisan backup:demo \<br>
                                &nbsp;&nbsp;--name="test_backup" \<br>
                                &nbsp;&nbsp;--description="Prueba del sistema"
                            </code>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gestionar Backups -->
        <div id="gestionar-backups" class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">📋 Gestionar Backups</h2>
            
            <div class="space-y-4">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Listado de Backups</h3>
                        <ul class="space-y-2 text-gray-600 dark:text-gray-300">
                            <li>• <strong>Filtros:</strong> Por estado, tipo y fecha</li>
                            <li>• <strong>Búsqueda:</strong> Por nombre o descripción</li>
                            <li>• <strong>Ordenamiento:</strong> Por fecha, tamaño o nombre</li>
                            <li>• <strong>Estados:</strong> Completado, Fallido, En proceso</li>
                            <li>• <strong>Tipos:</strong> Manual, Automático</li>
                        </ul>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Acciones Disponibles</h3>
                        <ul class="space-y-2 text-gray-600 dark:text-gray-300">
                            <li>• <strong>Ver detalles:</strong> Información completa del backup</li>
                            <li>• <strong>Descargar:</strong> Obtener archivo SQL</li>
                            <li>• <strong>Restaurar:</strong> Recuperar datos (con confirmación)</li>
                            <li>• <strong>Eliminar:</strong> Borrar backup (irreversible)</li>
                            <li>• <strong>Acciones masivas:</strong> Operaciones en lote</li>
                        </ul>
                    </div>
                </div>

                <div class="bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700 dark:text-yellow-300">
                                <strong>Recomendación:</strong> Mantén al menos 3 backups recientes y elimina los antiguos para ahorrar espacio.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Descargar Backup -->
        <div id="descargar-backup" class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">⬇️ Descargar Backup</h2>
            
            <div class="space-y-4">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Desde la Interfaz</h3>
                        <ol class="list-decimal list-inside space-y-2 text-gray-600 dark:text-gray-300">
                            <li>Ve al listado de backups</li>
                            <li>Localiza el backup que deseas descargar</li>
                            <li>Haz clic en el botón <strong>"Descargar"</strong></li>
                            <li>El archivo se descargará automáticamente</li>
                            <li>Guarda el archivo en una ubicación segura</li>
                        </ol>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Información del Archivo</h3>
                        <ul class="space-y-2 text-gray-600 dark:text-gray-300">
                            <li>• <strong>Formato:</strong> Archivo SQL (.sql)</li>
                            <li>• <strong>Contenido:</strong> Estructura y datos completos</li>
                            <li>• <strong>Tamaño:</strong> Variable según los datos</li>
                            <li>• <strong>Compresión:</strong> No comprimido por defecto</li>
                            <li>• <strong>Compatibilidad:</strong> MySQL 5.7+ y MariaDB</li>
                        </ul>
                    </div>
                </div>

                <div class="bg-green-50 dark:bg-green-900/20 border-l-4 border-green-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700 dark:text-green-300">
                                <strong>Seguridad:</strong> Los archivos de backup contienen información sensible. Almacénalos en ubicaciones seguras y con acceso restringido.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Restaurar Backup -->
        <div id="restaurar-backup" class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">🔄 Restaurar Backup</h2>
            
            <div class="space-y-4">
                <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700 dark:text-red-300">
                                <strong>¡ADVERTENCIA!</strong> La restauración eliminará todos los datos actuales y los reemplazará con los del backup. Esta acción es irreversible.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Proceso de Restauración</h3>
                        <ol class="list-decimal list-inside space-y-2 text-gray-600 dark:text-gray-300">
                            <li>Selecciona el backup a restaurar</li>
                            <li>Haz clic en <strong>"Restaurar"</strong></li>
                            <li>Confirma la acción escribiendo <strong>"CONFIRMAR"</strong></li>
                            <li>El sistema realizará la restauración</li>
                            <li>Verifica que los datos se restauraron correctamente</li>
                        </ol>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Recomendaciones</h3>
                        <ul class="space-y-2 text-gray-600 dark:text-gray-300">
                            <li>• <strong>Crear backup actual</strong> antes de restaurar</li>
                            <li>• <strong>Verificar compatibilidad</strong> de la versión</li>
                            <li>• <strong>Probar en entorno de desarrollo</strong> primero</li>
                            <li>• <strong>Notificar a usuarios</strong> sobre el mantenimiento</li>
                            <li>• <strong>Tener plan de rollback</strong> preparado</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Configuración Automática -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">⏰ Backups Automáticos</h2>
            
            <div class="space-y-4">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Programación</h3>
                        <ul class="space-y-2 text-gray-600 dark:text-gray-300">
                            <li>• <strong>Diario:</strong> Todos los días a las 2:00 AM</li>
                            <li>• <strong>Semanal:</strong> Domingos a las 1:00 AM</li>
                            <li>• <strong>Mensual:</strong> Primer día del mes a las 12:00 AM</li>
                            <li>• <strong>Configurable:</strong> Via archivo de configuración</li>
                        </ul>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Configuración</h3>
                        <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4">
                            <code class="text-sm text-gray-800 dark:text-gray-200">
                                # En .env<br>
                                BACKUP_RETENTION_DAYS=30<br>
                                BACKUP_STORAGE_PATH=storage/app/backups<br>
                                BACKUP_COMPRESSION=true
                            </code>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700 dark:text-blue-300">
                                <strong>Nota:</strong> Los backups automáticos requieren que el cron de Laravel esté configurado correctamente en el servidor.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Solución de Problemas -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">🔧 Solución de Problemas</h2>
            
            <div class="space-y-4">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Problemas Comunes</h3>
                        <div class="space-y-3">
                            <div class="border-l-4 border-red-400 pl-4">
                                <h4 class="font-medium text-red-600 dark:text-red-400">Error: "mysqldump no encontrado"</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-300">El sistema usará PHP como alternativa automáticamente.</p>
                            </div>
                            <div class="border-l-4 border-yellow-400 pl-4">
                                <h4 class="font-medium text-yellow-600 dark:text-yellow-400">Error: "Permisos denegados"</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-300">El sistema usará directorio temporal automáticamente.</p>
                            </div>
                            <div class="border-l-4 border-blue-400 pl-4">
                                <h4 class="font-medium text-blue-600 dark:text-blue-400">Error: "Conexión a base de datos"</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-300">Verifica la configuración de MySQL en .env</p>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Comandos de Diagnóstico</h3>
                        <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4 space-y-2">
                            <code class="text-sm text-gray-800 dark:text-gray-200 block">
                                # Verificar conexión a BD<br>
                                php artisan tinker<br>
                                DB::connection()->getPdo();
                            </code>
                            <code class="text-sm text-gray-800 dark:text-gray-200 block">
                                # Probar backup demo<br>
                                php artisan backup:demo
                            </code>
                            <code class="text-sm text-gray-800 dark:text-gray-200 block">
                                # Ver logs de backup<br>
                                tail -f storage/logs/laravel.log
                            </code>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contacto -->
        <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6">
            <div class="text-center">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">¿Necesitas Ayuda Adicional?</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4">Si tienes problemas con el sistema de backup, contacta al soporte técnico.</p>
                <div class="flex justify-center space-x-4">
                    <a href="{{ \App\Filament\Pages\Ayuda::getUrl() }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Centro de Ayuda
                    </a>
                    <a href="mailto:soporte@pae.edu.co" class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700 transition-colors">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Contactar Soporte
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
