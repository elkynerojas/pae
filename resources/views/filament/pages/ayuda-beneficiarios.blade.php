<x-filament-panels::page>
    <div class="space-y-8">
        <!-- Header -->
        <div class="text-center">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                Gestión de Beneficiarios - Guía Completa
            </h1>
            <p class="text-lg text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                Aprende a administrar los estudiantes beneficiarios del Programa de Alimentación Escolar de manera eficiente.
            </p>
        </div>

        <!-- Navegación rápida -->
        <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4 border border-green-200 dark:border-green-800">
            <h2 class="text-lg font-semibold text-green-900 dark:text-green-100 mb-3">Navegación Rápida</h2>
            <div class="flex flex-wrap gap-2">
                <a href="#registrar-beneficiario" class="px-3 py-1 bg-green-100 dark:bg-green-800 text-green-700 dark:text-green-300 rounded-full text-sm hover:bg-green-200 dark:hover:bg-green-700">Registrar Beneficiario</a>
                <a href="#editar-beneficiario" class="px-3 py-1 bg-green-100 dark:bg-green-800 text-green-700 dark:text-green-300 rounded-full text-sm hover:bg-green-200 dark:hover:bg-green-700">Editar Beneficiario</a>
                <a href="#filtros-busqueda" class="px-3 py-1 bg-green-100 dark:bg-green-800 text-green-700 dark:text-green-300 rounded-full text-sm hover:bg-green-200 dark:hover:bg-green-700">Filtros y Búsqueda</a>
                <a href="#gestion-masiva" class="px-3 py-1 bg-green-100 dark:bg-green-800 text-green-700 dark:text-green-300 rounded-full text-sm hover:bg-green-200 dark:hover:bg-green-700">Gestión Masiva</a>
                <a href="#reportes" class="px-3 py-1 bg-green-100 dark:bg-green-800 text-green-700 dark:text-green-300 rounded-full text-sm hover:bg-green-200 dark:hover:bg-green-700">Reportes</a>
            </div>
        </div>

        <!-- Registrar Beneficiario -->
        <div id="registrar-beneficiario" class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                <svg class="w-6 h-6 text-green-600 dark:text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Registrar Nuevo Beneficiario
            </h2>
            
            <div class="space-y-4">
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Pasos para registrar un beneficiario:</h3>
                    <ol class="list-decimal list-inside space-y-2 text-gray-700 dark:text-gray-300">
                        <li>Ve a <strong>Gestión > Beneficiarios</strong> en el menú principal</li>
                        <li>Haz clic en el botón <strong>"Nuevo beneficiario"</strong></li>
                        <li>Completa todos los campos del formulario:</li>
                    </ol>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Información Personal</h4>
                        <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                            <li><strong>Código:</strong> Código único del estudiante (requerido)</li>
                            <li><strong>Nombres:</strong> Nombre(s) del beneficiario (requerido)</li>
                            <li><strong>Apellidos:</strong> Apellidos del beneficiario (requerido)</li>
                            <li><strong>Fecha de Nacimiento:</strong> Fecha de nacimiento (requerido)</li>
                            <li><strong>Género:</strong> Masculino o Femenino (requerido)</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Información Académica</h4>
                        <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                            <li><strong>Grado:</strong> Grado escolar actual (requerido)</li>
                            <li><strong>Grupo:</strong> Grupo o sección (requerido)</li>
                            <li><strong>Observaciones:</strong> Notas adicionales (opcional)</li>
                            <li><strong>Estado:</strong> Activo/Inactivo (por defecto: Activo)</li>
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
                                El código del beneficiario debe ser único en el sistema. 
                                Se recomienda usar un formato consistente (ej: EST-2024-001).
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Editar Beneficiario -->
        <div id="editar-beneficiario" class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Editar Beneficiario Existente
            </h2>
            
            <div class="space-y-4">
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Pasos para editar un beneficiario:</h3>
                    <ol class="list-decimal list-inside space-y-2 text-gray-700 dark:text-gray-300">
                        <li>Ve a <strong>Gestión > Beneficiarios</strong></li>
                        <li>Busca el beneficiario en la lista o usa los filtros</li>
                        <li>Haz clic en el ícono de <strong>"Editar"</strong> (lápiz) en la fila del beneficiario</li>
                        <li>Modifica los campos necesarios</li>
                        <li>Haz clic en <strong>"Guardar cambios"</strong></li>
                    </ol>
                </div>

                <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h4 class="font-semibold text-green-800 dark:text-green-200">Consejo</h4>
                            <p class="text-green-700 dark:text-green-300 text-sm mt-1">
                                Puedes actualizar la información académica cuando el estudiante cambie de grado o grupo. 
                                El código del beneficiario no se puede modificar una vez creado.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtros y Búsqueda -->
        <div id="filtros-busqueda" class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                Filtros y Búsqueda de Beneficiarios
            </h2>
            
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Búsqueda General</h4>
                        <p class="text-gray-600 dark:text-gray-300 text-sm mb-3">
                            Utiliza la barra de búsqueda superior para encontrar beneficiarios por:
                        </p>
                        <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-1">
                            <li>• Código del beneficiario</li>
                            <li>• Nombre completo</li>
                            <li>• Apellidos</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Filtros Disponibles</h4>
                        <p class="text-gray-600 dark:text-gray-300 text-sm mb-3">
                            Usa los filtros para refinar tu búsqueda:
                        </p>
                        <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-1">
                            <li>• <strong>Por Grado:</strong> Filtra por grado escolar</li>
                            <li>• <strong>Por Grupo:</strong> Filtra por grupo o sección</li>
                            <li>• <strong>Por Género:</strong> Masculino o Femenino</li>
                            <li>• <strong>Por Estado:</strong> Activo o Inactivo</li>
                        </ul>
                    </div>
                </div>

                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Consejos de Búsqueda</h4>
                    <ul class="text-sm text-gray-700 dark:text-gray-300 space-y-1">
                        <li>• Puedes combinar búsqueda y filtros para resultados más precisos</li>
                        <li>• La búsqueda funciona con coincidencias parciales</li>
                        <li>• Usa los filtros para generar listas por grado y grupo</li>
                        <li>• Los filtros se pueden limpiar haciendo clic en "Limpiar filtros"</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Gestión Masiva -->
        <div id="gestion-masiva" class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                <svg class="w-6 h-6 text-purple-600 dark:text-purple-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
                Gestión Masiva de Beneficiarios
            </h2>
            
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Acciones Masivas Disponibles</h4>
                        <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-2">
                            <li>• <strong>Selección múltiple:</strong> Selecciona varios beneficiarios</li>
                            <li>• <strong>Cambio de estado:</strong> Activar/desactivar múltiples beneficiarios</li>
                            <li>• <strong>Eliminación masiva:</strong> Eliminar varios beneficiarios</li>
                            <li>• <strong>Exportación:</strong> Exportar datos seleccionados</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Proceso de Gestión Masiva</h4>
                        <ol class="text-sm text-gray-600 dark:text-gray-300 space-y-1">
                            <li>1. Usa los filtros para encontrar el grupo deseado</li>
                            <li>2. Selecciona los beneficiarios usando los checkboxes</li>
                            <li>3. Elige la acción masiva a realizar</li>
                            <li>4. Confirma la acción en el diálogo</li>
                        </ol>
                    </div>
                </div>

                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-red-600 dark:text-red-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <div>
                            <h4 class="font-semibold text-red-800 dark:text-red-200">Precaución</h4>
                            <p class="text-red-700 dark:text-red-300 text-sm mt-1">
                                Las acciones masivas no se pueden deshacer. Asegúrate de seleccionar 
                                correctamente los beneficiarios antes de confirmar la acción.
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
                Reportes de Beneficiarios
            </h2>
            
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                        <h4 class="font-semibold text-blue-900 dark:text-blue-100 mb-2">Reporte por Grado</h4>
                        <p class="text-blue-700 dark:text-blue-300 text-sm mb-3">
                            Lista de beneficiarios organizados por grado escolar.
                        </p>
                        <ul class="text-sm text-blue-600 dark:text-blue-400 space-y-1">
                            <li>• Total por grado</li>
                            <li>• Distribución por género</li>
                            <li>• Estado de activación</li>
                        </ul>
                    </div>
                    <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                        <h4 class="font-semibold text-green-900 dark:text-green-100 mb-2">Reporte por Grupo</h4>
                        <p class="text-green-700 dark:text-green-300 text-sm mb-3">
                            Beneficiarios agrupados por sección o grupo.
                        </p>
                        <ul class="text-sm text-green-600 dark:text-green-400 space-y-1">
                            <li>• Lista por grupo</li>
                            <li>• Códigos de beneficiarios</li>
                            <li>• Información de contacto</li>
                        </ul>
                    </div>
                    <div class="bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 rounded-lg p-4">
                        <h4 class="font-semibold text-purple-900 dark:text-purple-100 mb-2">Reporte General</h4>
                        <p class="text-purple-700 dark:text-purple-300 text-sm mb-3">
                            Estadísticas generales del programa.
                        </p>
                        <ul class="text-sm text-purple-600 dark:text-purple-400 space-y-1">
                            <li>• Total de beneficiarios</li>
                            <li>• Beneficiarios activos</li>
                            <li>• Distribución por edad</li>
                        </ul>
                    </div>
                </div>

                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Cómo Generar Reportes</h4>
                    <ol class="text-sm text-gray-700 dark:text-gray-300 space-y-1">
                        <li>1. Ve a la sección de Beneficiarios</li>
                        <li>2. Aplica los filtros deseados (grado, grupo, estado)</li>
                        <li>3. Haz clic en "Exportar" para descargar los datos</li>
                        <li>4. Selecciona el formato (Excel, PDF, CSV)</li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- Información Adicional -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                <svg class="w-6 h-6 text-gray-600 dark:text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Información Adicional
            </h2>
            
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Campos Importantes</h4>
                        <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-2">
                            <li>• <strong>Código:</strong> Identificador único, no modificable</li>
                            <li>• <strong>Estado:</strong> Activo = recibe alimentos, Inactivo = no recibe</li>
                            <li>• <strong>Observaciones:</strong> Notas importantes sobre el beneficiario</li>
                            <li>• <strong>Fecha de Nacimiento:</strong> Usada para cálculos de edad</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Buenas Prácticas</h4>
                        <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-2">
                            <li>• Mantén actualizada la información académica</li>
                            <li>• Usa códigos consistentes y únicos</li>
                            <li>• Desactiva beneficiarios que ya no participan</li>
                            <li>• Registra observaciones importantes</li>
                        </ul>
                    </div>
                </div>

                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h4 class="font-semibold text-blue-800 dark:text-blue-200">Nota Importante</h4>
                            <p class="text-blue-700 dark:text-blue-300 text-sm mt-1">
                                Los beneficiarios inactivos no aparecerán en las listas de entregas. 
                                Asegúrate de activar/desactivar beneficiarios según su participación en el programa.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
