<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Formulario de filtros --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            {{ $this->form }}
        </div>

        {{-- Tabla de resultados --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            {{ $this->table }}
        </div>

        {{-- Resumen de resultados --}}
        @if($this->getTableQuery()->count() > 0)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    Resumen del Reporte
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4">
                        <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                            {{ $this->getTableQuery()->count() }}
                        </div>
                        <div class="text-sm text-blue-600 dark:text-blue-400">
                            Total Entregas
                        </div>
                    </div>
                    
                    <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4">
                        <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                            {{ $this->getTableQuery()->where('estado', 'cerrada')->count() }}
                        </div>
                        <div class="text-sm text-green-600 dark:text-green-400">
                            Entregas Cerradas
                        </div>
                    </div>
                    
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 rounded-lg p-4">
                        <div class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">
                            {{ $this->getTableQuery()->where('estado', 'abierta')->count() }}
                        </div>
                        <div class="text-sm text-yellow-600 dark:text-yellow-400">
                            Entregas Abiertas
                        </div>
                    </div>
                    
                    <div class="bg-purple-50 dark:bg-purple-900/20 rounded-lg p-4">
                        <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">
                            {{ $this->getTableQuery()->withCount('beneficiarios')->get()->sum('beneficiarios_count') }}
                        </div>
                        <div class="text-sm text-purple-600 dark:text-purple-400">
                            Total Beneficiarios
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-filament-panels::page>
