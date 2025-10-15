<x-filament-panels::page>
    <div class="space-y-8">
        <!-- Header -->
        <div class="text-center">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                Configuración del Sistema - Guía Completa
            </h1>
            <p class="text-lg text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                Aprende a administrar la configuración del sistema, logs, mantenimiento y aspectos técnicos del Sistema PAE.
            </p>
        </div>

        <!-- Navegación rápida -->
        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">Navegación Rápida</h2>
            <div class="flex flex-wrap gap-2">
                <a href="#configuracion-general" class="px-3 py-1 bg-gray-100 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-full text-sm hover:bg-gray-200 dark:hover:bg-gray-500">Configuración General</a>
                <a href="#logs-sistema" class="px-3 py-1 bg-gray-100 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-full text-sm hover:bg-gray-200 dark:hover:bg-gray-500">Logs del Sistema</a>
                <a href="#mantenimiento" class="px-3 py-1 bg-gray-100 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-full text-sm hover:bg-gray-200 dark:hover:bg-gray-500">Mantenimiento</a>
                <a href="#respaldo-datos" class="px-3 py-1 bg-gray-100 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-full text-sm hover:bg-gray-200 dark:hover:bg-gray-500">Respaldo de Datos</a>
                <a href="#seguridad" class="px-3 py-1 bg-gray-100 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-full text-sm hover:bg-gray-200 dark:hover:bg-gray-500">Seguridad</a>
            </div>
        </div>

        <!-- Configuración General -->
        <div id="configuracion-general" class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                <svg class="w-6 h-6 text-gray-600 dark:text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Configuración General del Sistema
            </h2>
            
            <div class="space-y-4">
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Aspectos configurables:</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Configuración de Aplicación</h4>
                        <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                            <li>• <strong>Nombre del sistema:</strong> PAE - Brighton Pamplona</li>
                            <li>• <strong>Logo y branding:</strong> Personalización visual</li>
                            <li>• <strong>Zona horaria:</strong> Configuración regional</li>
                            <li>• <strong>Idioma:</strong> Español (predeterminado)</li>
                            <li>• <strong>Formato de fechas:</strong> DD/MM/YYYY</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Configuración de Base de Datos</h4>
                        <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                            <li>• <strong>Conexión:</strong> MySQL/MariaDB</li>
                            <li>• <strong>Host:</strong> localhost</li>
                            <li>• <strong>Puerto:</strong> 3306</li>
                            <li>• <strong>Charset:</strong> utf8mb4</li>
                            <li>• <strong>Timezone:</strong> UTC</li>
                        </ul>
                    </div>
                </div>

                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h4 class="font-semibold text-blue-800 dark:text-blue-200">Nota</h4>
                            <p class="text-blue-700 dark:text-blue-300 text-sm mt-1">
                                La mayoría de configuraciones se realizan a través del archivo .env y 
                                requieren acceso de administrador del servidor. Contacta al soporte técnico 
                                para cambios en la configuración del sistema.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Logs del Sistema -->
        <div id="logs-sistema" class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Logs del Sistema
            </h2>
            
            <div class="space-y-4">
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Tipos de logs disponibles:</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Logs de Aplicación</h4>
                        <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                            <li>• <strong>Acceso de usuarios:</strong> Login/logout</li>
                            <li>• <strong>Operaciones CRUD:</strong> Crear, leer, actualizar, eliminar</li>
                            <li>• <strong>Errores de aplicación:</strong> Excepciones y fallos</li>
                            <li>• <strong>Actividad de usuarios:</strong> Acciones realizadas</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Logs de Sistema</h4>
                        <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                            <li>• <strong>Logs de servidor web:</strong> Apache/Nginx</li>
                            <li>• <strong>Logs de base de datos:</strong> Consultas y errores</li>
                            <li>• <strong>Logs de PHP:</strong> Errores y warnings</li>
                            <li>• <strong>Logs de Laravel:</strong> Framework específicos</li>
                        </ul>
                    </div>
                </div>

                <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <div>
                            <h4 class="font-semibold text-yellow-800 dark:text-yellow-200">Importante</h4>
                            <p class="text-yellow-700 dark:text-yellow-300 text-sm mt-1">
                                Los logs se almacenan por un período limitado para optimizar el rendimiento. 
                                Los logs críticos se archivan automáticamente. Contacta al administrador 
                                del sistema para acceder a logs históricos.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mantenimiento -->
        <div id="mantenimiento" class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                <svg class="w-6 h-6 text-green-600 dark:text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Mantenimiento del Sistema
            </h2>
            
            <div class="space-y-4">
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Tareas de mantenimiento:</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Mantenimiento Automático</h4>
                        <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                            <li>• <strong>Limpieza de logs:</strong> Eliminación de logs antiguos</li>
                            <li>• <strong>Optimización de BD:</strong> Limpieza de índices</li>
                            <li>• <strong>Cache:</strong> Limpieza de caché temporal</li>
                            <li>• <strong>Sesiones:</strong> Eliminación de sesiones expiradas</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Mantenimiento Manual</h4>
                        <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                            <li>• <strong>Actualizaciones:</strong> Sistema y dependencias</li>
                            <li>• <strong>Respaldos:</strong> Base de datos y archivos</li>
                            <li>• <strong>Monitoreo:</strong> Rendimiento y espacio</li>
                            <li>• <strong>Seguridad:</strong> Revisión de accesos</li>
                        </ul>
                    </div>
                </div>

                <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h4 class="font-semibold text-green-800 dark:text-green-200">Recomendación</h4>
                            <p class="text-green-700 dark:text-green-300 text-sm mt-1">
                                El sistema realiza mantenimiento automático durante las horas de menor uso. 
                                Para tareas de mantenimiento manual, coordina con el equipo técnico para 
                                minimizar la interrupción del servicio.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Respaldo de Datos -->
        <div id="respaldo-datos" class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                </svg>
                Respaldo de Datos
            </h2>
            
            <div class="space-y-4">
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Estrategia de respaldo:</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                        <h4 class="font-semibold text-blue-900 dark:text-blue-100 mb-2">Respaldo Diario</h4>
                        <p class="text-blue-700 dark:text-blue-300 text-sm mb-3">
                            Respaldo completo de la base de datos.
                        </p>
                        <ul class="text-sm text-blue-600 dark:text-blue-400 space-y-1">
                            <li>• Base de datos completa</li>
                            <li>• Archivos de configuración</li>
                            <li>• Logs importantes</li>
                            <li>• Retención: 30 días</li>
                        </ul>
                    </div>
                    <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                        <h4 class="font-semibold text-green-900 dark:text-green-100 mb-2">Respaldo Semanal</h4>
                        <p class="text-green-700 dark:text-green-300 text-sm mb-3">
                            Respaldo completo del sistema.
                        </p>
                        <ul class="text-sm text-green-600 dark:text-green-400 space-y-1">
                            <li>• Base de datos</li>
                            <li>• Archivos de aplicación</li>
                            <li>• Configuraciones</li>
                            <li>• Retención: 12 semanas</li>
                        </ul>
                    </div>
                    <div class="bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 rounded-lg p-4">
                        <h4 class="font-semibold text-purple-900 dark:text-purple-100 mb-2">Respaldo Mensual</h4>
                        <p class="text-purple-700 dark:text-purple-300 text-sm mb-3">
                            Archivo a largo plazo.
                        </p>
                        <ul class="text-sm text-purple-600 dark:text-purple-400 space-y-1">
                            <li>• Respaldo completo</li>
                            <li>• Almacenamiento externo</li>
                            <li>• Verificación de integridad</li>
                            <li>• Retención: 12 meses</li>
                        </ul>
                    </div>
                </div>

                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-red-600 dark:text-red-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <div>
                            <h4 class="font-semibold text-red-800 dark:text-red-200">Importante</h4>
                            <p class="text-red-700 dark:text-red-300 text-sm mt-1">
                                Los respaldos se realizan automáticamente. En caso de necesidad de restauración, 
                                contacta inmediatamente al equipo técnico. No intentes restaurar respaldos 
                                sin supervisión técnica.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Seguridad -->
        <div id="seguridad" class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                <svg class="w-6 h-6 text-red-600 dark:text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
                Seguridad del Sistema
            </h2>
            
            <div class="space-y-4">
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Medidas de seguridad implementadas:</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Seguridad de Aplicación</h4>
                        <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                            <li>• <strong>Autenticación:</strong> Login seguro con hash de contraseñas</li>
                            <li>• <strong>Autorización:</strong> Control de acceso por roles</li>
                            <li>• <strong>CSRF Protection:</strong> Protección contra ataques</li>
                            <li>• <strong>Validación:</strong> Sanitización de datos de entrada</li>
                            <li>• <strong>Sesiones:</strong> Gestión segura de sesiones</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Seguridad de Infraestructura</h4>
                        <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                            <li>• <strong>HTTPS:</strong> Conexiones cifradas</li>
                            <li>• <strong>Firewall:</strong> Protección de red</li>
                            <li>• <strong>Actualizaciones:</strong> Parches de seguridad</li>
                            <li>• <strong>Monitoreo:</strong> Detección de intrusiones</li>
                            <li>• <strong>Respaldos:</strong> Protección de datos</li>
                        </ul>
                    </div>
                </div>

                <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <div>
                            <h4 class="font-semibold text-yellow-800 dark:text-yellow-200">Responsabilidades del Usuario</h4>
                            <p class="text-yellow-700 dark:text-yellow-300 text-sm mt-1">
                                Mantén tu contraseña segura, no compartas credenciales de acceso, 
                                cierra sesión cuando termines de usar el sistema, y reporta 
                                cualquier actividad sospechosa al equipo técnico.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contacto Técnico -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                Soporte Técnico
            </h2>
            
            <div class="space-y-4">
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h4 class="font-semibold text-blue-800 dark:text-blue-200">Información de Contacto</h4>
                            <div class="text-blue-700 dark:text-blue-300 text-sm mt-2 space-y-1">
                                <p><strong>Email técnico:</strong> soporte-tecnico@pae.edu.co</p>
                                <p><strong>Teléfono:</strong> +57 300 123 4567</p>
                                <p><strong>Horario:</strong> Lunes a Viernes: 8:00 AM - 6:00 PM</p>
                                <p><strong>Emergencias:</strong> 24/7 para problemas críticos</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Cuándo contactar al soporte técnico:</h4>
                    <ul class="text-sm text-gray-700 dark:text-gray-300 space-y-1">
                        <li>• Problemas de acceso al sistema</li>
                        <li>• Errores técnicos o fallos del sistema</li>
                        <li>• Necesidad de restauración de datos</li>
                        <li>• Cambios en la configuración del sistema</li>
                        <li>• Problemas de rendimiento</li>
                        <li>• Dudas sobre mantenimiento o actualizaciones</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
