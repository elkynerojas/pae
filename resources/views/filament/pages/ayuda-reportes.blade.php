<x-filament-panels::page>
    <div class="space-y-8">
        <!-- Header -->
        <div class="text-center">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                Reportes y Análisis - Guía Completa
            </h1>
            <p class="text-lg text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                Aprende a generar, interpretar y utilizar los reportes del Sistema PAE para tomar decisiones informadas.
            </p>
        </div>

        <!-- Navegación rápida -->
        <div class="bg-indigo-50 dark:bg-indigo-900/20 rounded-lg p-4 border border-indigo-200 dark:border-indigo-800">
            <h2 class="text-lg font-semibold text-indigo-900 dark:text-indigo-100 mb-3">Navegación Rápida</h2>
            <div class="flex flex-wrap gap-2">
                <a href="#tipos-reportes" class="px-3 py-1 bg-indigo-100 dark:bg-indigo-800 text-indigo-700 dark:text-indigo-300 rounded-full text-sm hover:bg-indigo-200 dark:hover:bg-indigo-700">Tipos de Reportes</a>
                <a href="#generar-reportes" class="px-3 py-1 bg-indigo-100 dark:bg-indigo-800 text-indigo-700 dark:text-indigo-300 rounded-full text-sm hover:bg-indigo-200 dark:hover:bg-indigo-700">Generar Reportes</a>
                <a href="#interpretar-datos" class="px-3 py-1 bg-indigo-100 dark:bg-indigo-800 text-indigo-700 dark:text-indigo-300 rounded-full text-sm hover:bg-indigo-200 dark:hover:bg-indigo-700">Interpretar Datos</a>
                <a href="#exportar-datos" class="px-3 py-1 bg-indigo-100 dark:bg-indigo-800 text-indigo-700 dark:text-indigo-300 rounded-full text-sm hover:bg-indigo-200 dark:hover:bg-indigo-700">Exportar Datos</a>
                <a href="#dashboard" class="px-3 py-1 bg-indigo-100 dark:bg-indigo-800 text-indigo-700 dark:text-indigo-300 rounded-full text-sm hover:bg-indigo-200 dark:hover:bg-indigo-700">Dashboard</a>
            </div>
        </div>

        <!-- Tipos de Reportes -->
        <div id="tipos-reportes" class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                Tipos de Reportes Disponibles
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Reportes de Beneficiarios -->
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                    <div class="flex items-center mb-3">
                        <div class="bg-blue-100 dark:bg-blue-800 p-2 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100">Beneficiarios</h3>
                    </div>
                    <ul class="text-sm text-blue-700 dark:text-blue-300 space-y-1">
                        <li>• Lista por grado y grupo</li>
                        <li>• Estadísticas demográficas</li>
                        <li>• Beneficiarios activos/inactivos</li>
                        <li>• Distribución por edad</li>
                    </ul>
                </div>

                <!-- Reportes de Inventario -->
                <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                    <div class="flex items-center mb-3">
                        <div class="bg-green-100 dark:bg-green-800 p-2 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-green-900 dark:text-green-100">Inventario</h3>
                    </div>
                    <ul class="text-sm text-green-700 dark:text-green-300 space-y-1">
                        <li>• Stock actual por producto</li>
                        <li>• Productos con stock bajo</li>
                        <li>• Valor total del inventario</li>
                        <li>• Movimientos de inventario</li>
                    </ul>
                </div>

                <!-- Reportes de Entregas -->
                <div class="bg-orange-50 dark:bg-orange-900/20 border border-orange-200 dark:border-orange-800 rounded-lg p-4">
                    <div class="flex items-center mb-3">
                        <div class="bg-orange-100 dark:bg-orange-800 p-2 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-orange-900 dark:text-orange-100">Entregas</h3>
                    </div>
                    <ul class="text-sm text-orange-700 dark:text-orange-300 space-y-1">
                        <li>• Entregas por período</li>
                        <li>• Beneficiarios atendidos</li>
                        <li>• Raciones entregadas</li>
                        <li>• Tendencias de consumo</li>
                    </ul>
                </div>

                <!-- Reportes de Recepciones -->
                <div class="bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 rounded-lg p-4">
                    <div class="flex items-center mb-3">
                        <div class="bg-purple-100 dark:bg-purple-800 p-2 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-purple-900 dark:text-purple-100">Recepciones</h3>
                    </div>
                    <ul class="text-sm text-purple-700 dark:text-purple-300 space-y-1">
                        <li>• Recepciones por fecha</li>
                        <li>• Productos más recibidos</li>
                        <li>• Cantidades totales</li>
                        <li>• Proveedores principales</li>
                    </ul>
                </div>

                <!-- Reportes de Usuarios -->
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                    <div class="flex items-center mb-3">
                        <div class="bg-red-100 dark:bg-red-800 p-2 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-red-900 dark:text-red-100">Usuarios</h3>
                    </div>
                    <ul class="text-sm text-red-700 dark:text-red-300 space-y-1">
                        <li>• Usuarios por rol</li>
                        <li>• Actividad de usuarios</li>
                        <li>• Accesos al sistema</li>
                        <li>• Logs de actividad</li>
                    </ul>
                </div>

                <!-- Reportes Generales -->
                <div class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                    <div class="flex items-center mb-3">
                        <div class="bg-gray-100 dark:bg-gray-600 p-2 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Generales</h3>
                    </div>
                    <ul class="text-sm text-gray-700 dark:text-gray-300 space-y-1">
                        <li>• Resumen ejecutivo</li>
                        <li>• Estadísticas generales</li>
                        <li>• Indicadores de rendimiento</li>
                        <li>• Comparativas por período</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Generar Reportes -->
        <div id="generar-reportes" class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                <svg class="w-6 h-6 text-green-600 dark:text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Cómo Generar Reportes
            </h2>
            
            <div class="space-y-4">
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Proceso paso a paso:</h3>
                    <ol class="list-decimal list-inside space-y-2 text-gray-700 dark:text-gray-300">
                        <li>Navega a la sección correspondiente (Beneficiarios, Inventario, Entregas, etc.)</li>
                        <li>Utiliza los filtros disponibles para refinar los datos</li>
                        <li>Haz clic en el botón "Exportar" o "Generar Reporte"</li>
                        <li>Selecciona el formato de salida deseado</li>
                        <li>Descarga el archivo generado</li>
                    </ol>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Filtros Disponibles</h4>
                        <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-2">
                            <li>• <strong>Por fecha:</strong> Rango de fechas específico</li>
                            <li>• <strong>Por estado:</strong> Activo, inactivo, todos</li>
                            <li>• <strong>Por categoría:</strong> Grado, grupo, tipo de producto</li>
                            <li>• <strong>Por usuario:</strong> Usuario que realizó la acción</li>
                            <li>• <strong>Búsqueda:</strong> Términos específicos</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Formatos de Exportación</h4>
                        <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-2">
                            <li>• <strong>Excel (.xlsx):</strong> Para análisis detallado</li>
                            <li>• <strong>PDF:</strong> Para presentaciones y archivo</li>
                            <li>• <strong>CSV:</strong> Para importar a otros sistemas</li>
                            <li>• <strong>Pantalla:</strong> Vista previa en el navegador</li>
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
                                Usa filtros específicos para generar reportes más precisos y útiles. 
                                Los reportes filtrados son más fáciles de analizar y tomar decisiones.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Interpretar Datos -->
        <div id="interpretar-datos" class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                <svg class="w-6 h-6 text-purple-600 dark:text-purple-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                Interpretación de Datos
            </h2>
            
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Indicadores Clave</h4>
                        <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-2">
                            <li>• <strong>Cobertura:</strong> % de beneficiarios atendidos</li>
                            <li>• <strong>Eficiencia:</strong> Entregas vs. planificado</li>
                            <li>• <strong>Stock:</strong> Días de inventario disponible</li>
                            <li>• <strong>Tendencias:</strong> Crecimiento o disminución</li>
                            <li>• <strong>Calidad:</strong> Cumplimiento de estándares</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Análisis de Tendencias</h4>
                        <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-2">
                            <li>• Compara períodos similares</li>
                            <li>• Identifica patrones estacionales</li>
                            <li>• Detecta anomalías o cambios</li>
                            <li>• Evalúa el impacto de cambios</li>
                            <li>• Proyecta necesidades futuras</li>
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
                                Los datos deben interpretarse en contexto. Considera factores externos como 
                                días festivos, cambios en el calendario escolar, o eventos especiales que 
                                puedan afectar las tendencias.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dashboard -->
        <div id="dashboard" class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                </svg>
                Dashboard y Métricas en Tiempo Real
            </h2>
            
            <div class="space-y-4">
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">El dashboard principal incluye:</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Métricas Principales</h4>
                        <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-2">
                            <li>• Total de usuarios registrados</li>
                            <li>• Beneficiarios activos</li>
                            <li>• Productos en inventario</li>
                            <li>• Entregas del mes actual</li>
                            <li>• Alertas de stock bajo</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Gráficos y Visualizaciones</h4>
                        <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-2">
                            <li>• Gráfico de entregas recientes</li>
                            <li>• Distribución por grados</li>
                            <li>• Tendencias de consumo</li>
                            <li>• Estado del inventario</li>
                            <li>• Actividad de usuarios</li>
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
                                El dashboard se actualiza automáticamente y proporciona una vista general 
                                rápida del estado del programa, permitiendo identificar problemas o 
                                oportunidades de mejora inmediatamente.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mejores Prácticas -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                <svg class="w-6 h-6 text-gray-600 dark:text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                </svg>
                Mejores Prácticas para Reportes
            </h2>
            
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Frecuencia de Reportes</h4>
                        <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-2">
                            <li>• <strong>Diarios:</strong> Entregas y recepciones</li>
                            <li>• <strong>Semanales:</strong> Resumen operativo</li>
                            <li>• <strong>Mensuales:</strong> Análisis de tendencias</li>
                            <li>• <strong>Trimestrales:</strong> Evaluación de impacto</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Uso de los Datos</h4>
                        <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-2">
                            <li>• Toma decisiones basadas en datos</li>
                            <li>• Identifica áreas de mejora</li>
                            <li>• Planifica recursos futuros</li>
                            <li>• Comunica resultados a stakeholders</li>
                        </ul>
                    </div>
                </div>

                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h4 class="font-semibold text-blue-800 dark:text-blue-200">Recomendación</h4>
                            <p class="text-blue-700 dark:text-blue-300 text-sm mt-1">
                                Establece un calendario regular de reportes y compártelos con el equipo. 
                                Los reportes regulares ayudan a mantener el programa en el camino correcto 
                                y permiten una respuesta rápida a los problemas.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
