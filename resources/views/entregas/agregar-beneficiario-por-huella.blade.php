<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Agregar Beneficiario por Huella - {{ $entrega->fecha->format('d/m/Y') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen py-8">
        <div class="max-w-4xl mx-auto px-4">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Agregar Beneficiario por Huella</h1>
                        <p class="text-gray-600">Entrega del {{ $entrega->fecha->format('d/m/Y') }} - {{ $entrega->racion->nombre }}</p>
                    </div>
                    <a href="{{ route('filament.admin.resources.entregas.view', $entrega) }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Volver
                    </a>
                </div>
            </div>

            <!-- Formulario -->
            <form action="{{ route('entregas.agregar-beneficiario-por-huella.store', $entrega) }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Información del Beneficiario Identificado -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-user mr-2"></i>Información del Beneficiario
                    </h2>
                    
                    <div id="beneficiario-info" class="hidden">
                        <div class="bg-green-50 border border-green-200 rounded-md p-4 mb-4">
                            <h3 class="font-medium text-green-900 mb-2">Beneficiario Identificado</h3>
                            <div id="beneficiario-details" class="text-green-800"></div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="cantidad_raciones" class="block text-sm font-medium text-gray-700 mb-2">
                                Cantidad de Raciones <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="cantidad_raciones" id="cantidad_raciones" 
                                   min="1" max="10" value="1" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label for="observaciones" class="block text-sm font-medium text-gray-700 mb-2">
                                Observaciones
                            </label>
                            <textarea name="observaciones" id="observaciones" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                      placeholder="Observaciones adicionales..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Identificación por Huella Dactilar -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-fingerprint mr-2"></i>Identificación por Huella Dactilar
                    </h2>
                    
                    <div class="space-y-4">
                        <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                            <p class="text-blue-800">
                                <i class="fas fa-info-circle mr-2"></i>
                                Coloque el dedo en el lector para identificar automáticamente al beneficiario.
                            </p>
                        </div>
                        
                        <div id="modo-desarrollo-warning" class="hidden bg-yellow-50 border border-yellow-200 rounded-md p-4">
                            <p class="text-yellow-800">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                <strong>Modo Desarrollo:</strong> El servicio del lector de huellas no está disponible. 
                                Se utilizará simulación para pruebas.
                            </p>
                        </div>
                        
                        <div class="text-center">
                            <button type="button" id="btn-identificar-huella" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-md transition-colors disabled:bg-gray-400 disabled:cursor-not-allowed">
                                <i class="fas fa-fingerprint mr-2"></i>Identificar por Huella
                            </button>
                        </div>
                        
                        <div id="status-huella" class="p-3 rounded-md bg-gray-100 text-gray-600 text-center">
                            Haga clic en "Identificar por Huella" para comenzar
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('filament.admin.resources.entregas.view', $entrega) }}" 
                           class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-md transition-colors">
                            Cancelar
                        </a>
                        <button type="submit" id="btn-guardar" 
                                class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md transition-colors disabled:bg-gray-400 disabled:cursor-not-allowed">
                            <i class="fas fa-save mr-2"></i>Agregar Beneficiario
                        </button>
                    </div>
                </div>

                <!-- Campos ocultos -->
                <input type="hidden" name="beneficiario_id" id="beneficiario_id" value="">
                <input type="hidden" name="huella_validada" id="huella_validada" value="false">
            </form>
        </div>
    </div>

    <!-- Script de Identificación por Huella -->
    <script>
        console.log('=== SCRIPT DE IDENTIFICACIÓN POR HUELLA CARGADO ===');
        
        // Variables globales
        let secugen_lic = "";
        let beneficiarioIdentificado = null;
        let huellaValidada = false;
        
        // Elementos del DOM
        const btnIdentificarHuella = document.getElementById('btn-identificar-huella');
        const btnGuardar = document.getElementById('btn-guardar');
        const statusHuella = document.getElementById('status-huella');
        const beneficiarioInfo = document.getElementById('beneficiario-info');
        const beneficiarioDetails = document.getElementById('beneficiario-details');
        const beneficiarioIdField = document.getElementById('beneficiario_id');
        const huellaValidadaField = document.getElementById('huella_validada');
        const modoDesarrolloWarning = document.getElementById('modo-desarrollo-warning');
        
        // Función para mostrar mensajes
        function showMessage(message, isError = false) {
            statusHuella.textContent = message;
            statusHuella.className = 'p-3 rounded-md text-center ' + (isError ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600');
        }
        
        // Función para CAPTURAR una huella (SDK SecuGen)
        function CallSGIFPGetData(successCall, failCall) {
            const uri = "https://localhost:8443/SGIFPCapture";
            console.log('Iniciando solicitud HTTP a:', uri);
            
            const xmlhttp = new XMLHttpRequest();
            
            xmlhttp.onreadystatechange = function () {
                console.log('Estado de la solicitud:', xmlhttp.readyState, 'HTTP Status:', xmlhttp.status);
                
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    console.log('Respuesta HTTP exitosa recibida');
                    console.log('Contenido de la respuesta:', xmlhttp.responseText);
                    
                    try {
                        const fpobject = JSON.parse(xmlhttp.responseText);
                        console.log('JSON parseado exitosamente:', fpobject);
                        successCall(fpobject);
                    } catch (parseError) {
                        console.error('Error al parsear JSON:', parseError);
                        console.error('Respuesta recibida:', xmlhttp.responseText);
                        failCall(xmlhttp.status);
                    }
                } else if (xmlhttp.readyState == 4 && xmlhttp.status != 200) {
                    console.error('Error HTTP:', xmlhttp.status, xmlhttp.statusText);
                    console.error('Respuesta de error:', xmlhttp.responseText);
                    failCall(xmlhttp.status);
                }
            };
            
            xmlhttp.onerror = function () { 
                console.error('Error de red en la solicitud HTTP');
                failCall(xmlhttp.status); 
            };
            
            xmlhttp.ontimeout = function () {
                console.error('Timeout en la solicitud HTTP');
                failCall(408);
            };
            
            let params = "Timeout=10000&Quality=50&licstr=" + encodeURIComponent(secugen_lic) + "&templateFormat=ISO";
            console.log('Parámetros a enviar:', params);
            
            xmlhttp.open("POST", uri, true);
            xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xmlhttp.timeout = 15000;
            
            console.log('Enviando solicitud HTTP...');
            xmlhttp.send(params);
        }
        
        // Función para simular captura de huella cuando el servicio no está disponible
        function simularCapturaHuella() {
            console.log('=== MODO DESARROLLO: Simulando captura de huella ===');
            
            // Generar una huella simulada
            const huellaSimulada = 'SIMULATED_FINGERPRINT_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
            
            return Promise.resolve(huellaSimulada);
        }
        
        // Función para capturar huella
        function capturarHuella() {
            return new Promise((resolve, reject) => {
                console.log('Ejecutando CallSGIFPGetData...');
                console.log('Parámetros de la solicitud:');
                console.log('- Timeout: 10000ms');
                console.log('- Quality: 50');
                console.log('- Template Format: ISO');
                
                CallSGIFPGetData(
                    (result) => {
                        console.log('Respuesta recibida del lector:', result);
                        console.log('ErrorCode:', result.ErrorCode);
                        
                        if (result.ErrorCode == 0) {
                            console.log('Captura exitosa, plantilla recibida');
                            console.log('Longitud de la plantilla:', result.TemplateBase64 ? result.TemplateBase64.length : 'null');
                            resolve(result.TemplateBase64);
                        } else {
                            console.error('Error en la captura. Código:', result.ErrorCode);
                            reject(new Error("Error en la captura. Código: " + result.ErrorCode));
                        }
                    },
                    (status) => {
                        console.error('Error de conexión con el lector. Estado HTTP:', status);
                        console.error('Posibles causas:');
                        console.error('- El servicio del lector no está ejecutándose');
                        console.error('- Problema de conectividad');
                        console.error('- Puerto 8443 bloqueado');
                        
                        // En modo desarrollo, usar simulación
                        console.warn('=== ACTIVANDO MODO DESARROLLO ===');
                        console.warn('El servicio del lector no está disponible, usando simulación');
                        
                        // Mostrar warning de modo desarrollo
                        modoDesarrolloWarning.classList.remove('hidden');
                        
                        simularCapturaHuella()
                            .then(huellaSimulada => {
                                console.log('Huella simulada generada:', huellaSimulada);
                                resolve(huellaSimulada);
                            })
                            .catch(error => {
                                console.error('Error en simulación:', error);
                                reject(new Error("No se pudo conectar con el servicio del lector y falló la simulación. Estado: " + status));
                            });
                    }
                );
            });
        }
        
        // Función para identificar beneficiario por huella
        async function identificarBeneficiarioPorHuella() {
            console.log('=== INICIANDO IDENTIFICACIÓN POR HUELLA ===');
            console.log('Timestamp:', new Date().toISOString());
            
            try {
                showMessage('Coloque el dedo en el lector para identificar...', false);
                
                // Capturar huella actual
                const huellaCapturada = await capturarHuella();
                
                console.log('=== CAPTURA EXITOSA ===');
                console.log('Longitud de la huella capturada:', huellaCapturada ? huellaCapturada.length : 'null');
                
                showMessage('Identificando beneficiario...', false);
                
                // Enviar huella al servidor para identificación
                const response = await fetch('/huella/identificar', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify({
                        huella_capturada: huellaCapturada
                    })
                });
                
                const result = await response.json();
                console.log('Respuesta del servidor:', result);
                
                if (result.success && result.beneficiario) {
                    showMessage(`¡Beneficiario identificado! Coincidencia: ${result.puntaje_coincidencia} puntos`, false);
                    
                    // Mostrar información del beneficiario
                    beneficiarioIdentificado = result.beneficiario;
                    beneficiarioDetails.innerHTML = `
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <strong>Código:</strong> ${result.beneficiario.codigo}
                            </div>
                            <div>
                                <strong>Nombre:</strong> ${result.beneficiario.nombre}
                            </div>
                            <div>
                                <strong>Grado:</strong> ${result.beneficiario.grado || 'N/A'}
                            </div>
                            <div>
                                <strong>Grupo:</strong> ${result.beneficiario.grupo || 'N/A'}
                            </div>
                        </div>
                    `;
                    beneficiarioInfo.classList.remove('hidden');
                    
                    // Llenar campos ocultos
                    beneficiarioIdField.value = result.beneficiario.id;
                    huellaValidada = true;
                    huellaValidadaField.value = 'true';
                    btnGuardar.disabled = false;
                    
                    console.log('Beneficiario identificado exitosamente:', result.beneficiario);
                } else {
                    showMessage(result.message || 'No se pudo identificar al beneficiario', true);
                    
                    // Limpiar información
                    beneficiarioIdentificado = null;
                    beneficiarioInfo.classList.add('hidden');
                    beneficiarioIdField.value = '';
                    huellaValidada = false;
                    huellaValidadaField.value = 'false';
                    btnGuardar.disabled = true;
                }
                
            } catch (error) {
                console.error('=== ERROR EN IDENTIFICACIÓN ===');
                console.error('Tipo de error:', error.constructor.name);
                console.error('Mensaje de error:', error.message);
                console.error('Stack trace:', error.stack);
                
                showMessage(`Error: ${error.message}`, true);
                
                // Limpiar información
                beneficiarioIdentificado = null;
                beneficiarioInfo.classList.add('hidden');
                beneficiarioIdField.value = '';
                huellaValidada = false;
                huellaValidadaField.value = 'false';
                btnGuardar.disabled = true;
            }
        }
        
        // Event listeners
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Configurando event listeners');
            
            // Listener para el botón de identificación
            btnIdentificarHuella.addEventListener('click', function() {
                identificarBeneficiarioPorHuella();
            });
            
            // Inicializar estado
            btnGuardar.disabled = true;
            showMessage('Haga clic en "Identificar por Huella" para comenzar', false);
        });
        
        console.log('Script de identificación por huella configurado completamente');
    </script>
</body>
</html>



