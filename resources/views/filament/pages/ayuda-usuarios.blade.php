<x-filament-panels::page>
    <div class="space-y-8">
        <!-- Header -->
        <div class="text-center">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                Gestión de Usuarios - Guía Completa
            </h1>
            <p class="text-lg text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                Aprende a administrar usuarios, roles y permisos en el Sistema PAE de manera eficiente y segura.
            </p>
        </div>

        <!-- Navegación rápida -->
        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 border border-blue-200 dark:border-blue-800">
            <h2 class="text-lg font-semibold text-blue-900 dark:text-blue-100 mb-3">Navegación Rápida</h2>
            <div class="flex flex-wrap gap-2">
                <a href="#crear-usuario" class="px-3 py-1 bg-blue-100 dark:bg-blue-800 text-blue-700 dark:text-blue-300 rounded-full text-sm hover:bg-blue-200 dark:hover:bg-blue-700">Crear Usuario</a>
                <a href="#editar-usuario" class="px-3 py-1 bg-blue-100 dark:bg-blue-800 text-blue-700 dark:text-blue-300 rounded-full text-sm hover:bg-blue-200 dark:hover:bg-blue-700">Editar Usuario</a>
                <a href="#roles-permisos" class="px-3 py-1 bg-blue-100 dark:bg-blue-800 text-blue-700 dark:text-blue-300 rounded-full text-sm hover:bg-blue-200 dark:hover:bg-blue-700">Roles y Permisos</a>
                <a href="#filtros-busqueda" class="px-3 py-1 bg-blue-100 dark:bg-blue-800 text-blue-700 dark:text-blue-300 rounded-full text-sm hover:bg-blue-200 dark:hover:bg-blue-700">Filtros y Búsqueda</a>
                <a href="#seguridad" class="px-3 py-1 bg-blue-100 dark:bg-blue-800 text-blue-700 dark:text-blue-300 rounded-full text-sm hover:bg-blue-200 dark:hover:bg-blue-700">Seguridad</a>
            </div>
        </div>

        <!-- Crear Usuario -->
        <div id="crear-usuario" class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                <svg class="w-6 h-6 text-green-600 dark:text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Crear Nuevo Usuario
            </h2>
            
            <div class="space-y-4">
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Pasos para crear un usuario:</h3>
                    <ol class="list-decimal list-inside space-y-2 text-gray-700 dark:text-gray-300">
                        <li>Ve a <strong>Administración > Usuarios</strong> en el menú principal</li>
                        <li>Haz clic en el botón <strong>"Nuevo usuario"</strong> (esquina superior derecha)</li>
                        <li>Completa todos los campos del formulario:</li>
                    </ol>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Información Personal</h4>
                        <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                            <li><strong>Nombres:</strong> Nombre(s) del usuario (requerido)</li>
                            <li><strong>Apellidos:</strong> Apellidos del usuario (requerido)</li>
                            <li><strong>Email:</strong> Correo electrónico único (requerido)</li>
                            <li><strong>Teléfono:</strong> Número de contacto (opcional)</li>
                            <li><strong>Cargo:</strong> Posición o cargo del usuario (opcional)</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Configuración de Acceso</h4>
                        <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                            <li><strong>Rol:</strong> Selecciona el rol apropiado (requerido)</li>
                            <li><strong>Contraseña:</strong> Mínimo 8 caracteres (requerido)</li>
                            <li><strong>Confirmar Contraseña:</strong> Repite la contraseña</li>
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
                                El email debe ser único en el sistema. Una vez creado el usuario, recibirá las credenciales de acceso.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Editar Usuario -->
        <div id="editar-usuario" class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Editar Usuario Existente
            </h2>
            
            <div class="space-y-4">
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Pasos para editar un usuario:</h3>
                    <ol class="list-decimal list-inside space-y-2 text-gray-700 dark:text-gray-300">
                        <li>Ve a <strong>Administración > Usuarios</strong></li>
                        <li>Busca el usuario en la lista o usa los filtros</li>
                        <li>Haz clic en el ícono de <strong>"Editar"</strong> (lápiz) en la fila del usuario</li>
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
                                Si no cambias la contraseña, déjala en blanco para mantener la actual. 
                                El sistema validará que el nuevo email no esté en uso por otro usuario.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Roles y Permisos -->
        <div id="roles-permisos" class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                <svg class="w-6 h-6 text-purple-600 dark:text-purple-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
                Roles y Permisos del Sistema
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Administrador -->
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                    <div class="flex items-center mb-3">
                        <div class="bg-red-100 dark:bg-red-800 p-2 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-red-900 dark:text-red-100">Administrador</h3>
                    </div>
                    <p class="text-red-700 dark:text-red-300 text-sm mb-3">
                        Acceso completo al sistema y todas sus funcionalidades.
                    </p>
                    <ul class="text-sm text-red-600 dark:text-red-400 space-y-1">
                        <li>• Gestión completa de usuarios</li>
                        <li>• Acceso a todos los módulos</li>
                        <li>• Configuración del sistema</li>
                        <li>• Reportes avanzados</li>
                        <li>• Logs y auditoría</li>
                    </ul>
                </div>

                <!-- Gestor -->
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                    <div class="flex items-center mb-3">
                        <div class="bg-blue-100 dark:bg-blue-800 p-2 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100">Gestor</h3>
                    </div>
                    <p class="text-blue-700 dark:text-blue-300 text-sm mb-3">
                        Gestión operativa del programa de alimentación escolar.
                    </p>
                    <ul class="text-sm text-blue-600 dark:text-blue-400 space-y-1">
                        <li>• Gestión de beneficiarios</li>
                        <li>• Gestión de productos</li>
                        <li>• Gestión de entregas</li>
                        <li>• Reportes básicos</li>
                        <li>• Consulta de inventario</li>
                    </ul>
                </div>

                <!-- Operador -->
                <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                    <div class="flex items-center mb-3">
                        <div class="bg-green-100 dark:bg-green-800 p-2 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-green-900 dark:text-green-100">Operador</h3>
                    </div>
                    <p class="text-green-700 dark:text-green-300 text-sm mb-3">
                        Operaciones diarias y consultas del sistema.
                    </p>
                    <ul class="text-sm text-green-600 dark:text-green-400 space-y-1">
                        <li>• Consulta de beneficiarios</li>
                        <li>• Registro de entregas</li>
                        <li>• Consulta de inventario</li>
                        <li>• Reportes básicos</li>
                        <li>• Acceso limitado</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Filtros y Búsqueda -->
        <div id="filtros-busqueda" class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                Filtros y Búsqueda de Usuarios
            </h2>
            
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Búsqueda General</h4>
                        <p class="text-gray-600 dark:text-gray-300 text-sm mb-3">
                            Utiliza la barra de búsqueda superior para encontrar usuarios por:
                        </p>
                        <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-1">
                            <li>• Nombre completo</li>
                            <li>• Apellidos</li>
                            <li>• Dirección de email</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Filtros Disponibles</h4>
                        <p class="text-gray-600 dark:text-gray-300 text-sm mb-3">
                            Usa los filtros para refinar tu búsqueda:
                        </p>
                        <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-1">
                            <li>• <strong>Por Rol:</strong> Admin, Gestor, Operador</li>
                            <li>• <strong>Por Estado:</strong> Activo, Inactivo</li>
                        </ul>
                    </div>
                </div>

                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Consejos de Búsqueda</h4>
                    <ul class="text-sm text-gray-700 dark:text-gray-300 space-y-1">
                        <li>• Puedes combinar búsqueda y filtros para resultados más precisos</li>
                        <li>• La búsqueda es sensible a mayúsculas y minúsculas</li>
                        <li>• Usa palabras parciales para encontrar coincidencias</li>
                        <li>• Los filtros se pueden limpiar haciendo clic en "Limpiar filtros"</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Seguridad -->
        <div id="seguridad" class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                <svg class="w-6 h-6 text-red-600 dark:text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
                Medidas de Seguridad
            </h2>
            
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Protecciones del Sistema</h4>
                        <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-2">
                            <li>• <strong>Autenticación requerida:</strong> Todas las rutas protegidas</li>
                            <li>• <strong>Prevención de auto-eliminación:</strong> No puedes eliminar tu propio usuario</li>
                            <li>• <strong>Prevención de auto-desactivación:</strong> No puedes desactivar tu propia cuenta</li>
                            <li>• <strong>Contraseñas hasheadas:</strong> Almacenamiento seguro</li>
                            <li>• <strong>Validación CSRF:</strong> Protección contra ataques</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Buenas Prácticas</h4>
                        <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-2">
                            <li>• Usa contraseñas seguras (mínimo 8 caracteres)</li>
                            <li>• Asigna roles apropiados según las responsabilidades</li>
                            <li>• Desactiva usuarios inactivos en lugar de eliminarlos</li>
                            <li>• Revisa regularmente los accesos y permisos</li>
                            <li>• Mantén actualizada la información de contacto</li>
                        </ul>
                    </div>
                </div>

                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-red-600 dark:text-red-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <div>
                            <h4 class="font-semibold text-red-800 dark:text-red-200">Importante - Seguridad</h4>
                            <p class="text-red-700 dark:text-red-300 text-sm mt-1">
                                Solo los usuarios con rol de Administrador pueden gestionar otros usuarios. 
                                Mantén siempre actualizada la información de seguridad y contacta al soporte 
                                si detectas actividades sospechosas.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Acciones Disponibles -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                <svg class="w-6 h-6 text-gray-600 dark:text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Acciones Disponibles por Usuario
            </h2>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acción</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Descripción</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Disponible para</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">Ver</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">Ver información detallada del usuario</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">Todos los roles</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">Editar</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">Modificar información del usuario</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">Administrador</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">Activar/Desactivar</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">Cambiar estado del usuario</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">Administrador</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">Eliminar</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">Eliminar usuario del sistema</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">Administrador</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-filament-panels::page>
