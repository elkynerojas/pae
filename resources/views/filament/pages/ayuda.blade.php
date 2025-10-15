<x-filament-panels::page>
    <div class="space-y-8">
        <!-- Header -->
        <div class="text-center">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                Centro de Ayuda - Sistema PAE
            </h1>
            <p class="text-lg text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                Bienvenido al centro de ayuda del Sistema PAE (Programa de Alimentación Escolar). 
                Aquí encontrarás guías detalladas para administrar cada módulo del sistema.
            </p>
        </div>

        <!-- Módulos de Ayuda -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Administración -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center mb-4">
                    <div class="bg-blue-100 dark:bg-blue-900 p-3 rounded-lg mr-4">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Administración</h3>
                </div>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Gestión de usuarios, roles, permisos y configuración del sistema.
                </p>
                <ul class="space-y-2 text-sm text-gray-500 dark:text-gray-400">
                    <li>• Gestión de usuarios y roles</li>
                    <li>• Configuración de permisos</li>
                    <li>• Logs del sistema</li>
                    <li>• Configuración general</li>
                </ul>
                <div class="mt-4">
                    <a href="{{ \App\Filament\Pages\AyudaUsuarios::getUrl() }}" 
                       class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium">
                        Ver guía completa
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Gestión de Beneficiarios -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center mb-4">
                    <div class="bg-green-100 dark:bg-green-900 p-3 rounded-lg mr-4">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Beneficiarios</h3>
                </div>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Administración de estudiantes beneficiarios del programa de alimentación.
                </p>
                <ul class="space-y-2 text-sm text-gray-500 dark:text-gray-400">
                    <li>• Registro de beneficiarios</li>
                    <li>• Gestión por grados y grupos</li>
                    <li>• Información personal y académica</li>
                    <li>• Estados y observaciones</li>
                </ul>
                <div class="mt-4">
                    <a href="{{ \App\Filament\Pages\AyudaBeneficiarios::getUrl() }}" 
                       class="inline-flex items-center text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300 font-medium">
                        Ver guía completa
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Inventario -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center mb-4">
                    <div class="bg-purple-100 dark:bg-purple-900 p-3 rounded-lg mr-4">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Inventario</h3>
                </div>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Gestión de productos, tipos, presentaciones y control de inventario.
                </p>
                <ul class="space-y-2 text-sm text-gray-500 dark:text-gray-400">
                    <li>• Gestión de productos</li>
                    <li>• Tipos y presentaciones</li>
                    <li>• Control de inventario</li>
                    <li>• Reportes de stock</li>
                </ul>
                <div class="mt-4">
                    <a href="{{ \App\Filament\Pages\AyudaInventario::getUrl() }}" 
                       class="inline-flex items-center text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300 font-medium">
                        Ver guía completa
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Operaciones -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center mb-4">
                    <div class="bg-orange-100 dark:bg-orange-900 p-3 rounded-lg mr-4">
                        <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Operaciones</h3>
                </div>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Gestión de entregas, recepciones, raciones y operaciones diarias.
                </p>
                <ul class="space-y-2 text-sm text-gray-500 dark:text-gray-400">
                    <li>• Gestión de entregas</li>
                    <li>• Recepciones de productos</li>
                    <li>• Configuración de raciones</li>
                    <li>• Reportes operativos</li>
                </ul>
                <div class="mt-4">
                    <a href="{{ \App\Filament\Pages\AyudaOperaciones::getUrl() }}" 
                       class="inline-flex items-center text-orange-600 dark:text-orange-400 hover:text-orange-800 dark:hover:text-orange-300 font-medium">
                        Ver guía completa
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Reportes y Análisis -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center mb-4">
                    <div class="bg-indigo-100 dark:bg-indigo-900 p-3 rounded-lg mr-4">
                        <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Reportes</h3>
                </div>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Generación de reportes, estadísticas y análisis del sistema.
                </p>
                <ul class="space-y-2 text-sm text-gray-500 dark:text-gray-400">
                    <li>• Reportes de entregas</li>
                    <li>• Estadísticas de beneficiarios</li>
                    <li>• Análisis de inventario</li>
                    <li>• Exportación de datos</li>
                </ul>
                <div class="mt-4">
                    <a href="{{ \App\Filament\Pages\AyudaReportes::getUrl() }}" 
                       class="inline-flex items-center text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 font-medium">
                        Ver guía completa
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Configuración del Sistema -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center mb-4">
                    <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded-lg mr-4">
                        <svg class="w-6 h-6 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Configuración</h3>
                </div>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Configuración general del sistema, logs y mantenimiento.
                </p>
                <ul class="space-y-2 text-sm text-gray-500 dark:text-gray-400">
                    <li>• Configuración general</li>
                    <li>• Logs del sistema</li>
                    <li>• Mantenimiento</li>
                    <li>• Respaldo de datos</li>
                </ul>
                <div class="mt-4">
                    <a href="{{ \App\Filament\Pages\AyudaSistema::getUrl() }}" 
                       class="inline-flex items-center text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 font-medium">
                        Ver guía completa
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Sistema de Backup -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center mb-4">
                    <div class="bg-purple-100 dark:bg-purple-900 p-3 rounded-lg mr-4">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Sistema de Backup</h3>
                </div>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Gestión completa de respaldos de la base de datos y recuperación de datos.
                </p>
                <ul class="space-y-2 text-sm text-gray-500 dark:text-gray-400">
                    <li>• Backups manuales y automáticos</li>
                    <li>• Descarga y restauración</li>
                    <li>• Gestión de archivos</li>
                    <li>• Estadísticas y monitoreo</li>
                </ul>
                <div class="mt-4">
                    <a href="{{ \App\Filament\Pages\AyudaBackup::getUrl() }}" 
                       class="inline-flex items-center text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300 font-medium">
                        Ver guía completa
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Sección de Preguntas Frecuentes -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Preguntas Frecuentes</h2>
            <div class="space-y-4">
                <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                        ¿Cómo puedo crear un nuevo usuario?
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Ve a la sección de Administración > Usuarios y haz clic en "Nuevo usuario". 
                        Completa todos los campos requeridos y asigna el rol apropiado.
                    </p>
                </div>
                <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                        ¿Cómo registro una entrega de alimentos?
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Ve a Operaciones > Entregas, crea una nueva entrega seleccionando la fecha, 
                        la ración y los beneficiarios que recibirán los alimentos.
                    </p>
                </div>
                <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                        ¿Cómo actualizo el inventario?
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Ve a Inventario > Inventario y edita las cantidades de los productos. 
                        También puedes registrar recepciones de nuevos productos.
                    </p>
                </div>
                <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                        ¿Cómo creo un backup de la base de datos?
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Ve a Backup en el menú lateral y haz clic en "Crear Backup". 
                        También puedes usar el comando <code class="bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">php artisan backup:demo</code> para pruebas.
                    </p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                        ¿Cómo genero reportes?
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Utiliza los filtros en cada sección para generar reportes específicos. 
                        También puedes exportar los datos en formato Excel o PDF.
                    </p>
                </div>
            </div>
        </div>

        <!-- Información de Contacto -->
        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-6 border border-blue-200 dark:border-blue-800">
            <div class="flex items-start">
                <div class="bg-blue-100 dark:bg-blue-800 p-3 rounded-lg mr-4">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100 mb-2">
                        ¿Necesitas ayuda adicional?
                    </h3>
                    <p class="text-blue-700 dark:text-blue-300 mb-4">
                        Si no encuentras la información que buscas o necesitas asistencia personalizada, 
                        no dudes en contactar al equipo de soporte técnico.
                    </p>
                    <div class="flex flex-wrap gap-4 text-sm text-blue-600 dark:text-blue-400">
                        <span>📧 soporte@pae.edu.co</span>
                        <span>📞 +57 300 123 4567</span>
                        <span>🕒 Lunes a Viernes: 8:00 AM - 5:00 PM</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
