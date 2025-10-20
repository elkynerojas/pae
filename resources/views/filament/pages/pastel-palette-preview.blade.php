<x-filament-panels::page>
    <div class="space-y-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">
                🎨 Preview de Paletas Pasteles
            </h2>
            <p class="text-gray-600 dark:text-gray-400 mb-6">
                Selecciona una paleta de colores pasteles suaves para tu tema de Filament. 
                Cada paleta está diseñada para ser elegante y fácil de leer.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($this->getPalettes() as $key => $palette)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <!-- Header de la paleta -->
                    <div class="p-4" style="background: linear-gradient(135deg, {{ $palette['primary'] }} 0%, {{ $palette['secondary'] }} 100%);">
                        <h3 class="text-lg font-semibold text-white">{{ $palette['name'] }}</h3>
                        <p class="text-sm text-white opacity-90">{{ $palette['description'] }}</p>
                    </div>
                    
                    <!-- Colores principales -->
                    <div class="p-4">
                        <div class="grid grid-cols-3 gap-3 mb-4">
                            <div class="text-center">
                                <div class="w-12 h-12 mx-auto rounded-lg shadow-sm mb-2" style="background-color: {{ $palette['primary'] }};"></div>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Primario</p>
                                <p class="text-xs font-mono text-gray-500">{{ $palette['primary'] }}</p>
                            </div>
                            <div class="text-center">
                                <div class="w-12 h-12 mx-auto rounded-lg shadow-sm mb-2" style="background-color: {{ $palette['secondary'] }};"></div>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Secundario</p>
                                <p class="text-xs font-mono text-gray-500">{{ $palette['secondary'] }}</p>
                            </div>
                            <div class="text-center">
                                <div class="w-12 h-12 mx-auto rounded-lg shadow-sm mb-2" style="background-color: {{ $palette['tertiary'] }};"></div>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Terciario</p>
                                <p class="text-xs font-mono text-gray-500">{{ $palette['tertiary'] }}</p>
                            </div>
                        </div>
                        
                        <!-- Paleta completa -->
                        <div class="mb-4">
                            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Paleta Completa</h4>
                            <div class="grid grid-cols-5 gap-1">
                                @foreach($palette['colors'] as $shade => $color)
                                    <div class="text-center">
                                        <div class="w-8 h-8 mx-auto rounded shadow-sm mb-1" style="background-color: {{ $color }};"></div>
                                        <p class="text-xs text-gray-500">{{ $shade }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Preview de componentes -->
                        <div class="space-y-2">
                            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300">Preview de Componentes</h4>
                            
                            <!-- Botón -->
                            <button class="w-full px-3 py-2 rounded text-sm font-medium text-white shadow-sm" style="background-color: {{ $palette['primary'] }};">
                                Botón Primario
                            </button>
                            
                            <!-- Badge -->
                            <div class="flex justify-center">
                                <span class="px-2 py-1 rounded-full text-xs font-medium text-white" style="background-color: {{ $palette['secondary'] }};">
                                    Badge Secundario
                                </span>
                            </div>
                            
                            <!-- Card preview -->
                            <div class="border rounded-lg p-2" style="border-color: {{ $palette['tertiary'] }}; background-color: {{ $palette['colors'][50] }};">
                                <div class="text-xs text-gray-600" style="color: {{ $palette['colors'][800] }};">
                                    Card con estilo {{ $palette['name'] }}
                                </div>
                            </div>
                        </div>
                        
                        <!-- Botón de aplicación -->
                        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <div class="text-center">
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                    Para aplicar esta paleta, ejecuta:
                                </p>
                                <div class="bg-gray-100 dark:bg-gray-800 rounded-lg p-3 mb-3">
                                    <code class="text-sm text-gray-800 dark:text-gray-200">
                                        php artisan theme:apply-pastel {{ $key }}
                                    </code>
                                </div>
                                <button onclick="copyToClipboard('php artisan theme:apply-pastel {{ $key }}')" 
                                        class="w-full px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg text-sm font-medium transition-colors duration-200">
                                    📋 Copiar Comando
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Información adicional -->
        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100 mb-2">
                💡 Información sobre las Paletas
            </h3>
            <div class="text-blue-800 dark:text-blue-200 space-y-2">
                <p>• <strong>Colores Pasteles:</strong> Diseñados para ser suaves y agradables a la vista</p>
                <p>• <strong>Alto Contraste:</strong> Todos los colores cumplen con estándares de accesibilidad WCAG</p>
                <p>• <strong>Modo Oscuro:</strong> Soporte automático para tema oscuro</p>
                <p>• <strong>Responsive:</strong> Optimizado para todos los tamaños de pantalla</p>
            </div>
        </div>
        
        <!-- Comandos útiles -->
        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                🛠️ Comandos Útiles
            </h3>
            <div class="space-y-2 text-sm font-mono text-gray-700 dark:text-gray-300">
                <p><span class="text-gray-500">#</span> Ver todas las paletas disponibles</p>
                <p class="ml-4">php artisan theme:show-pastels</p>
                
                <p class="mt-3"><span class="text-gray-500">#</span> Aplicar una paleta específica</p>
                <p class="ml-4">php artisan theme:apply-pastel [nombre-paleta]</p>
                
                <p class="mt-3"><span class="text-gray-500">#</span> Verificar contrastes</p>
                <p class="ml-4">php artisan theme:check-contrast</p>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                // Mostrar notificación de éxito
                const button = event.target;
                const originalText = button.textContent;
                button.textContent = '✅ Copiado!';
                button.classList.add('bg-green-100', 'text-green-800');
                
                setTimeout(() => {
                    button.textContent = originalText;
                    button.classList.remove('bg-green-100', 'text-green-800');
                }, 2000);
            }).catch(function(err) {
                console.error('Error al copiar: ', err);
                alert('Error al copiar al portapapeles');
            });
        }
    </script>
</x-filament-panels::page>
