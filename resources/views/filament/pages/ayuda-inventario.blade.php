<x-filament-panels::page>
    <div class="space-y-8">
        <!-- Header -->
        <div class="text-center">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                Gestión de Inventario - Guía Completa
            </h1>
            <p class="text-lg text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                Aprende a administrar productos, tipos, presentaciones y control de inventario en el Sistema PAE.
            </p>
        </div>

        <!-- Navegación rápida -->
        <div class="bg-purple-50 dark:bg-purple-900/20 rounded-lg p-4 border border-purple-200 dark:border-purple-800">
            <h2 class="text-lg font-semibold text-purple-900 dark:text-purple-100 mb-3">Navegación Rápida</h2>
            <div class="flex flex-wrap gap-2">
                <a href="#productos" class="px-3 py-1 bg-purple-100 dark:bg-purple-800 text-purple-700 dark:text-purple-300 rounded-full text-sm hover:bg-purple-200 dark:hover:bg-purple-700">Productos</a>
                <a href="#tipos-presentaciones" class="px-3 py-1 bg-purple-100 dark:bg-purple-800 text-purple-700 dark:text-purple-300 rounded-full text-sm hover:bg-purple-200 dark:hover:bg-purple-700">Tipos y Presentaciones</a>
                <a href="#inventario" class="px-3 py-1 bg-purple-100 dark:bg-purple-800 text-purple-700 dark:text-purple-300 rounded-full text-sm hover:bg-purple-200 dark:hover:bg-purple-700">Control de Inventario</a>
                <a href="#recepciones" class="px-3 py-1 bg-purple-100 dark:bg-purple-800 text-purple-700 dark:text-purple-300 rounded-full text-sm hover:bg-purple-200 dark:hover:bg-purple-700">Recepciones</a>
                <a href="#reportes" class="px-3 py-1 bg-purple-100 dark:bg-purple-800 text-purple-700 dark:text-purple-300 rounded-full text-sm hover:bg-purple-200 dark:hover:bg-purple-700">Reportes</a>
            </div>
        </div>

        <!-- Gestión de Productos -->
        <div id="productos" class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                <svg class="w-6 h-6 text-purple-600 dark:text-purple-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                Gestión de Productos
            </h2>
            
            <div class="space-y-4">
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Pasos para crear un producto:</h3>
                    <ol class="list-decimal list-inside space-y-2 text-gray-700 dark:text-gray-300">
                        <li>Ve a <strong>Inventario > Productos</strong> en el menú principal</li>
                        <li>Haz clic en el botón <strong>"Nuevo producto"</strong></li>
                        <li>Completa todos los campos del formulario:</li>
                    </ol>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Información Básica</h4>
                        <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                            <li><strong>Nombre:</strong> Nombre del producto (requerido)</li>
                            <li><strong>Descripción:</strong> Descripción detallada (opcional)</li>
                            <li><strong>Tipo de Producto:</strong> Selecciona o crea un tipo (requerido)</li>
                            <li><strong>Presentación:</strong> Selecciona o crea una presentación (requerido)</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Configuración</h4>
                        <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                            <li><strong>Estado:</strong> Activo/Inactivo (por defecto: Activo)</li>
                            <li><strong>Observaciones:</strong> Notas adicionales (opcional)</li>
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
                                Puedes crear tipos y presentaciones directamente desde el formulario de productos 
                                usando los botones "+" junto a los campos de selección.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tipos y Presentaciones -->
        <div id="tipos-presentaciones" class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
                Tipos y Presentaciones de Productos
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tipos de Productos -->
                <div class="bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-200 dark:border-indigo-800 rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-indigo-900 dark:text-indigo-100 mb-3">Tipos de Productos</h3>
                    <p class="text-indigo-700 dark:text-indigo-300 text-sm mb-3">
                        Los tipos categorizan los productos por su naturaleza o uso.
                    </p>
                    <div class="space-y-2">
                        <h4 class="font-semibold text-indigo-800 dark:text-indigo-200 text-sm">Ejemplos comunes:</h4>
                        <ul class="text-sm text-indigo-600 dark:text-indigo-400 space-y-1">
                            <li>• Cereales y granos</li>
                            <li>• Lácteos</li>
                            <li>• Frutas y verduras</li>
                            <li>• Proteínas</li>
                            <li>• Bebidas</li>
                        </ul>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('filament.admin.resources.tipo-productos.index') }}" 
                           class="inline-flex items-center text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 text-sm font-medium">
                            Gestionar tipos
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Presentaciones -->
                <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-green-900 dark:text-green-100 mb-3">Presentaciones</h3>
                    <p class="text-green-700 dark:text-green-300 text-sm mb-3">
                        Las presentaciones definen cómo se presenta o empaqueta el producto.
                    </p>
                    <div class="space-y-2">
                        <h4 class="font-semibold text-green-800 dark:text-green-200 text-sm">Ejemplos comunes:</h4>
                        <ul class="text-sm text-green-600 dark:text-green-400 space-y-1">
                            <li>• Bolsa 500g</li>
                            <li>• Caja 1kg</li>
                            <li>• Unidad individual</li>
                            <li>• Paquete 6 unidades</li>
                            <li>• Litro</li>
                        </ul>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('filament.admin.resources.presentacion-productos.index') }}" 
                           class="inline-flex items-center text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300 text-sm font-medium">
                            Gestionar presentaciones
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="mt-6 bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Cómo crear tipos y presentaciones:</h4>
                <ol class="text-sm text-gray-700 dark:text-gray-300 space-y-1">
                    <li>1. Ve a la sección correspondiente (Tipos o Presentaciones)</li>
                    <li>2. Haz clic en "Nuevo tipo" o "Nueva presentación"</li>
                    <li>3. Completa el nombre y descripción</li>
                    <li>4. Establece el estado (Activo/Inactivo)</li>
                    <li>5. Guarda los cambios</li>
                </ol>
            </div>
        </div>

        <!-- Control de Inventario -->
        <div id="inventario" class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                <svg class="w-6 h-6 text-orange-600 dark:text-orange-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
                Control de Inventario
            </h2>
            
            <div class="space-y-4">
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Funcionalidades del inventario:</h3>
                    <ul class="list-disc list-inside space-y-2 text-gray-700 dark:text-gray-300">
                        <li>Registro de cantidades disponibles por producto</li>
                        <li>Control de cantidades mínimas</li>
                        <li>Alertas de stock bajo</li>
                        <li>Seguimiento de movimientos</li>
                    </ul>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Actualizar Inventario</h4>
                        <ol class="text-sm text-gray-600 dark:text-gray-300 space-y-1">
                            <li>1. Ve a <strong>Inventario > Inventario</strong></li>
                            <li>2. Busca el producto a actualizar</li>
                            <li>3. Haz clic en "Editar"</li>
                            <li>4. Modifica la cantidad disponible</li>
                            <li>5. Establece la cantidad mínima</li>
                            <li>6. Guarda los cambios</li>
                        </ol>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Alertas de Stock</h4>
                        <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-1">
                            <li>• Productos con stock bajo aparecen en rojo</li>
                            <li>• Se muestran alertas en el dashboard</li>
                            <li>• Reportes de productos por agotarse</li>
                            <li>• Notificaciones automáticas</li>
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
                                Mantén actualizado el inventario para evitar problemas en las entregas. 
                                Las cantidades se actualizan automáticamente con las recepciones y entregas.
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

                <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h4 class="font-semibold text-green-800 dark:text-green-200">Beneficio</h4>
                            <p class="text-green-700 dark:text-green-300 text-sm mt-1">
                                Las recepciones actualizan automáticamente el inventario y generan un registro 
                                histórico de todos los productos recibidos.
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
                Reportes de Inventario
            </h2>
            
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                        <h4 class="font-semibold text-blue-900 dark:text-blue-100 mb-2">Reporte de Stock</h4>
                        <p class="text-blue-700 dark:text-blue-300 text-sm mb-3">
                            Inventario actual con cantidades disponibles.
                        </p>
                        <ul class="text-sm text-blue-600 dark:text-blue-400 space-y-1">
                            <li>• Cantidades por producto</li>
                            <li>• Productos con stock bajo</li>
                            <li>• Valor total del inventario</li>
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
                            <li>• Proveedores principales</li>
                        </ul>
                    </div>
                    <div class="bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 rounded-lg p-4">
                        <h4 class="font-semibold text-purple-900 dark:text-purple-100 mb-2">Reporte de Movimientos</h4>
                        <p class="text-purple-700 dark:text-purple-300 text-sm mb-3">
                            Seguimiento de entradas y salidas.
                        </p>
                        <ul class="text-sm text-purple-600 dark:text-purple-400 space-y-1">
                            <li>• Movimientos por período</li>
                            <li>• Productos más utilizados</li>
                            <li>• Tendencias de consumo</li>
                        </ul>
                    </div>
                </div>

                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Cómo Generar Reportes</h4>
                    <ol class="text-sm text-gray-700 dark:text-gray-300 space-y-1">
                        <li>1. Ve a la sección de Inventario o Recepciones</li>
                        <li>2. Aplica los filtros deseados (fecha, producto, tipo)</li>
                        <li>3. Haz clic en "Exportar" para descargar los datos</li>
                        <li>4. Selecciona el formato (Excel, PDF, CSV)</li>
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
                Mejores Prácticas
            </h2>
            
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Organización</h4>
                        <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-2">
                            <li>• Usa nombres descriptivos para productos</li>
                            <li>• Mantén tipos y presentaciones organizados</li>
                            <li>• Establece cantidades mínimas realistas</li>
                            <li>• Revisa regularmente el inventario</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Control</h4>
                        <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-2">
                            <li>• Registra recepciones inmediatamente</li>
                            <li>• Verifica cantidades antes de guardar</li>
                            <li>• Mantén observaciones detalladas</li>
                            <li>• Genera reportes periódicamente</li>
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
                                Establece un horario fijo para actualizar el inventario y revisar las alertas de stock bajo. 
                                Esto ayudará a mantener un control eficiente del programa de alimentación.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
