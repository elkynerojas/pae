<x-filament-panels::page>
    <div class="space-y-8">
        <!-- Header -->
        <div class="text-center">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                Operaciones - Guía Completa
            </h1>
            <p class="text-lg text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                Aprende a gestionar entregas, recepciones, raciones y todas las operaciones diarias del Sistema PAE.
            </p>
        </div>

        <!-- Navegación rápida -->
        <div class="bg-orange-50 dark:bg-orange-900/20 rounded-lg p-4 border border-orange-200 dark:border-orange-800">
            <h2 class="text-lg font-semibold text-orange-900 dark:text-orange-100 mb-3">Navegación Rápida</h2>
            <div class="flex flex-wrap gap-2">
                <a href="#entregas" class="px-3 py-1 bg-orange-100 dark:bg-orange-800 text-orange-700 dark:text-orange-300 rounded-full text-sm hover:bg-orange-200 dark:hover:bg-orange-700">Entregas</a>
                <a href="#raciones" class="px-3 py-1 bg-orange-100 dark:bg-orange-800 text-orange-700 dark:text-orange-300 rounded-full text-sm hover:bg-orange-200 dark:hover:bg-orange-700">Raciones</a>
                <a href="#recepciones" class="px-3 py-1 bg-orange-100 dark:bg-orange-800 text-orange-700 dark:text-orange-300 rounded-full text-sm hover:bg-orange-200 dark:hover:bg-orange-700">Recepciones</a>
                <a href="#proceso-diario" class="px-3 py-1 bg-orange-100 dark:bg-orange-800 text-orange-700 dark:text-orange-300 rounded-full text-sm hover:bg-orange-200 dark:hover:bg-orange-700">Proceso Diario</a>
                <a href="#reportes" class="px-3 py-1 bg-orange-100 dark:bg-orange-800 text-orange-700 dark:text-orange-300 rounded-full text-sm hover:bg-orange-200 dark:hover:bg-orange-700">Reportes</a>
            </div>
        </div>

        <!-- Gestión de Entregas -->
        <div id="entregas" class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                <svg class="w-6 h-6 text-orange-600 dark:text-orange-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
                Gestión de Entregas
            </h2>
            
            <div class="space-y-4">
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Pasos para registrar una entrega:</h3>
                    <ol class="list-decimal list-inside space-y-2 text-gray-700 dark:text-gray-300">
                        <li>Ve a <strong>Operaciones > Entregas</strong> en el menú principal</li>
                        <li>Haz clic en el botón <strong>"Nueva entrega"</strong></li>
                        <li>Completa la información básica:</li>
                    </ol>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Información de la Entrega</h4>
                        <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                            <li><strong>Fecha:</strong> Fecha de la entrega (requerido)</li>
                            <li><strong>Ración:</strong> Selecciona la ración a entregar (requerido)</li>
                            <li><strong>Observaciones:</strong> Notas adicionales (opcional)</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Beneficiarios</h4>
                        <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                            <li>• Selecciona los beneficiarios que recibirán la entrega</li>
                            <li>• Puedes filtrar por grado, grupo o estado</li>
                            <li>• Verifica las cantidades asignadas</li>
                            <li>• El sistema calcula automáticamente el total</li>
                        </ul>
                    </div>
                </div>

                <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h4 class="font-semibold text-green-800 dark:text-green-200">Beneficio</h4>
                            <p class="text-green-700 dark:text-green-300 text-sm mt-1">
                                Las entregas se registran automáticamente en el historial de cada beneficiario 
                                y actualizan el inventario del sistema.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gestión de Raciones -->
        <div id="raciones" class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                Gestión de Raciones
            </h2>
            
            <div class="space-y-4">
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Pasos para crear una ración:</h3>
                    <ol class="list-decimal list-inside space-y-2 text-gray-700 dark:text-gray-300">
                        <li>Ve a <strong>Operaciones > Raciones</strong></li>
                        <li>Haz clic en <strong>"Nueva ración"</strong></li>
                        <li>Completa la información básica:</li>
                    </ol>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Información de la Ración</h4>
                        <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                            <li><strong>Nombre:</strong> Nombre descriptivo de la ración (requerido)</li>
                            <li><strong>Descripción:</strong> Descripción detallada (opcional)</li>
                            <li><strong>Estado:</strong> Activo/Inactivo (por defecto: Activo)</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Productos de la Ración</h4>
                        <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                            <li>• Selecciona los productos que incluye la ración</li>
                            <li>• Define las cantidades por producto</li>
                            <li>• Verifica que los productos estén disponibles</li>
                            <li>• El sistema calcula el costo total</li>
                        </ul>
                    </div>
                </div>

                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h4 class="font-semibold text-blue-800 dark:text-blue-200">Consejo</h4>
                            <p class="text-blue-700 dark:text-blue-300 text-sm mt-1">
                                Crea raciones estándar para diferentes momentos del día (desayuno, almuerzo, merienda) 
                                para facilitar la gestión de entregas.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recepciones -->
        <div id="recepciones" class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                <svg class="w-6 h-6 text-green-600 dark:text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                </svg>
                Gestión de Recepciones
            </h2>
            
            <div class="space-y-4">
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Pasos para registrar una recepción:</h3>
                    <ol class="list-decimal list-inside space-y-2 text-gray-700 dark:text-gray-300">
                        <li>Ve a <strong>Operaciones > Recepciones</strong></li>
                        <li>Haz clic en <strong>"Nueva recepción"</strong></li>
                        <li>Completa la información básica:</li>
                    </ol>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Información de la Recepción</h4>
                        <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                            <li><strong>Fecha:</strong> Fecha de recepción (requerido)</li>
                            <li><strong>Hora:</strong> Hora de recepción (requerido)</li>
                            <li><strong>Usuario:</strong> Usuario que registra (automático)</li>
                            <li><strong>Observaciones:</strong> Notas adicionales (opcional)</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Productos Recibidos</h4>
                        <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                            <li>• Selecciona los productos recibidos</li>
                            <li>• Ingresa las cantidades por producto</li>
                            <li>• Verifica las cantidades antes de guardar</li>
                            <li>• El inventario se actualiza automáticamente</li>
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
                                Verifica cuidadosamente las cantidades recibidas antes de confirmar la recepción. 
                                Una vez guardada, la recepción no se puede modificar.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Proceso Diario -->
        <div id="proceso-diario" class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Proceso Diario de Operaciones
            </h2>
            
            <div class="space-y-4">
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Flujo de trabajo recomendado:</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Mañana -->
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                        <div class="flex items-center mb-3">
                            <div class="bg-blue-100 dark:bg-blue-800 p-2 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <h4 class="text-lg font-semibold text-blue-900 dark:text-blue-100">Mañana</h4>
                        </div>
                        <ol class="text-sm text-blue-700 dark:text-blue-300 space-y-1">
                            <li>1. Revisar inventario disponible</li>
                            <li>2. Verificar productos recibidos</li>
                            <li>3. Planificar entregas del día</li>
                            <li>4. Preparar raciones necesarias</li>
                        </ol>
                    </div>

                    <!-- Tarde -->
                    <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                        <div class="flex items-center mb-3">
                            <div class="bg-green-100 dark:bg-green-800 p-2 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h4 class="text-lg font-semibold text-green-900 dark:text-green-100">Tarde</h4>
                        </div>
                        <ol class="text-sm text-green-700 dark:text-green-300 space-y-1">
                            <li>1. Registrar entregas realizadas</li>
                            <li>2. Actualizar inventario</li>
                            <li>3. Registrar nuevas recepciones</li>
                            <li>4. Revisar alertas de stock</li>
                        </ol>
                    </div>

                    <!-- Final del día -->
                    <div class="bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 rounded-lg p-4">
                        <div class="flex items-center mb-3">
                            <div class="bg-purple-100 dark:bg-purple-800 p-2 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h4 class="text-lg font-semibold text-purple-900 dark:text-purple-100">Final del día</h4>
                        </div>
                        <ol class="text-sm text-purple-700 dark:text-purple-300 space-y-1">
                            <li>1. Generar reportes del día</li>
                            <li>2. Verificar inventario final</li>
                            <li>3. Planificar para el siguiente día</li>
                            <li>4. Revisar observaciones</li>
                        </ol>
                    </div>
                </div>

                <div class="bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-200 dark:border-indigo-800 rounded-lg p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h4 class="font-semibold text-indigo-800 dark:text-indigo-200">Recomendación</h4>
                            <p class="text-indigo-700 dark:text-indigo-300 text-sm mt-1">
                                Mantén un registro diario de todas las operaciones y revisa regularmente 
                                los reportes para identificar tendencias y mejorar la eficiencia del programa.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reportes -->
        <div id="reportes" class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                Reportes Operativos
            </h2>
            
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-orange-50 dark:bg-orange-900/20 border border-orange-200 dark:border-orange-800 rounded-lg p-4">
                        <h4 class="font-semibold text-orange-900 dark:text-orange-100 mb-2">Reporte de Entregas</h4>
                        <p class="text-orange-700 dark:text-orange-300 text-sm mb-3">
                            Seguimiento de entregas por período.
                        </p>
                        <ul class="text-sm text-orange-600 dark:text-orange-400 space-y-1">
                            <li>• Entregas por fecha</li>
                            <li>• Beneficiarios atendidos</li>
                            <li>• Raciones entregadas</li>
                            <li>• Tendencias de consumo</li>
                        </ul>
                    </div>
                    <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                        <h4 class="font-semibold text-green-900 dark:text-green-100 mb-2">Reporte de Recepciones</h4>
                        <p class="text-green-700 dark:text-green-300 text-sm mb-3">
                            Historial de productos recibidos.
                        </p>
                        <ul class="text-sm text-green-600 dark:text-green-400 space-y-1">
                            <li>• Recepciones por fecha</li>
                            <li>• Productos más recibidos</li>
                            <li>• Cantidades totales</li>
                            <li>• Proveedores principales</li>
                        </ul>
                    </div>
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                        <h4 class="font-semibold text-blue-900 dark:text-blue-100 mb-2">Reporte de Raciones</h4>
                        <p class="text-blue-700 dark:text-blue-300 text-sm mb-3">
                            Análisis de raciones utilizadas.
                        </p>
                        <ul class="text-sm text-blue-600 dark:text-blue-400 space-y-1">
                            <li>• Raciones más utilizadas</li>
                            <li>• Productos por ración</li>
                            <li>• Costos por ración</li>
                            <li>• Eficiencia nutricional</li>
                        </ul>
                    </div>
                </div>

                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Cómo Generar Reportes</h4>
                    <ol class="text-sm text-gray-700 dark:text-gray-300 space-y-1">
                        <li>1. Ve a la sección correspondiente (Entregas, Recepciones, Raciones)</li>
                        <li>2. Aplica los filtros deseados (fecha, ración, beneficiario)</li>
                        <li>3. Haz clic en "Exportar" para descargar los datos</li>
                        <li>4. Selecciona el formato (Excel, PDF, CSV)</li>
                        <li>5. Los reportes incluyen gráficos y estadísticas</li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- Mejores Prácticas -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                <svg class="w-6 h-6 text-gray-600 dark:text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                </svg>
                Mejores Prácticas Operativas
            </h2>
            
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Organización</h4>
                        <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-2">
                            <li>• Planifica las entregas con anticipación</li>
                            <li>• Mantén raciones estándar bien definidas</li>
                            <li>• Registra recepciones inmediatamente</li>
                            <li>• Verifica inventario antes de entregas</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Control de Calidad</h4>
                        <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-2">
                            <li>• Verifica fechas de vencimiento</li>
                            <li>• Inspecciona productos recibidos</li>
                            <li>• Mantén registros detallados</li>
                            <li>• Reporta problemas inmediatamente</li>
                        </ul>
                    </div>
                </div>

                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-red-600 dark:text-red-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <div>
                            <h4 class="font-semibold text-red-800 dark:text-red-200">Importante - Seguridad Alimentaria</h4>
                            <p class="text-red-700 dark:text-red-300 text-sm mt-1">
                                Siempre verifica la calidad y frescura de los productos antes de incluirlos en las entregas. 
                                Mantén registros detallados de todas las operaciones para auditorías y seguimiento.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
