<div class="p-6">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Estadísticas de Actividad del Sistema</h2>
        <p class="text-gray-600 dark:text-gray-400">Últimos 30 días</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total de Acciones -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total de Acciones</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($estadisticas['total_acciones']) }}</p>
                </div>
            </div>
        </div>

        <!-- Usuarios Activos -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 dark:bg-green-900 rounded-lg">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Usuarios Activos</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $estadisticas['usuarios_activos'] }}</p>
                </div>
            </div>
        </div>

        <!-- Acción Más Común -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-100 dark:bg-yellow-900 rounded-lg">
                    <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Acción Más Común</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">
                        @if(!empty($estadisticas['acciones_por_tipo']))
                            {{ array_search(max($estadisticas['acciones_por_tipo']), $estadisticas['acciones_por_tipo']) }}
                        @else
                            N/A
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Tabla Más Afectada -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-purple-100 dark:bg-purple-900 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Tabla Más Afectada</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">
                        @if(!empty($estadisticas['tablas_mas_afectadas']))
                            {{ array_search(max($estadisticas['tablas_mas_afectadas']), $estadisticas['tablas_mas_afectadas']) }}
                        @else
                            N/A
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráfico de Acciones por Tipo -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Acciones por Tipo</h3>
            <div class="space-y-3">
                @foreach($estadisticas['acciones_por_tipo'] as $accion => $total)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ $accion }}</span>
                        <div class="flex items-center">
                            <div class="w-32 bg-gray-200 dark:bg-gray-700 rounded-full h-2 mr-3">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ ($total / $estadisticas['total_acciones']) * 100 }}%"></div>
                            </div>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $total }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Tablas Más Afectadas</h3>
            <div class="space-y-3">
                @foreach($estadisticas['tablas_mas_afectadas'] as $tabla => $total)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ $tabla }}</span>
                        <div class="flex items-center">
                            <div class="w-32 bg-gray-200 dark:bg-gray-700 rounded-full h-2 mr-3">
                                <div class="bg-green-600 h-2 rounded-full" style="width: {{ ($total / max($estadisticas['tablas_mas_afectadas'])) * 100 }}%"></div>
                            </div>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $total }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
