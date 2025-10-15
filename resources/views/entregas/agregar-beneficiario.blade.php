<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Agregar Beneficiario - {{ $entrega->fecha->format('d/m/Y') }}</title>
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
                        <h1 class="text-2xl font-bold text-gray-900">Agregar Beneficiario</h1>
                        <p class="text-gray-600">Entrega del {{ $entrega->fecha->format('d/m/Y') }} - {{ $entrega->racion->nombre }}</p>
                    </div>
                    <a href="{{ route('filament.admin.resources.entregas.view', $entrega) }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Volver
                    </a>
                </div>
            </div>

            <!-- Formulario -->
            <form action="{{ route('entregas.agregar-beneficiario.store', $entrega) }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Información del Beneficiario -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-user mr-2"></i>Información del Beneficiario
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="beneficiario_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Beneficiario <span class="text-red-500">*</span>
                            </label>
                            <select name="beneficiario_id" id="beneficiario_id" required 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Seleccione un beneficiario</option>
                                @foreach($beneficiariosDisponibles as $beneficiario)
                                    <option value="{{ $beneficiario->id }}" 
                                            data-nombre="{{ $beneficiario->nombres }} {{ $beneficiario->apellidos }}"
                                            data-codigo="{{ $beneficiario->codigo }}">
                                        {{ $beneficiario->codigo }} - {{ $beneficiario->nombres }} {{ $beneficiario->apellidos }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label for="cantidad_raciones" class="block text-sm font-medium text-gray-700 mb-2">
                                Cantidad de Raciones <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="cantidad_raciones" id="cantidad_raciones" 
                                   min="1" max="10" value="1" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <label for="observaciones" class="block text-sm font-medium text-gray-700 mb-2">
                            Observaciones
                        </label>
                        <textarea name="observaciones" id="observaciones" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  placeholder="Observaciones adicionales..."></textarea>
                    </div>
                </div>

                <!-- Validación de Huella Dactilar -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-fingerprint mr-2"></i>Validación de Huella Dactilar
                    </h2>
                    
                    <div class="space-y-4">
                        <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                            <p class="text-blue-800">
                                <i class="fas fa-info-circle mr-2"></i>
                                Seleccione un beneficiario y luego capture su huella para validar la identidad.
                            </p>
                        </div>
                        
                        <div id="info-beneficiario" class="hidden">
                            <div class="bg-gray-50 border border-gray-200 rounded-md p-4">
                                <h3 class="font-medium text-gray-900 mb-2">Información del Beneficiario</h3>
                                <div id="beneficiario-info" class="text-gray-600"></div>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <button type="button" id="btn-validar-huella" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-md transition-colors disabled:bg-gray-400 disabled:cursor-not-allowed"
                                    disabled>
                                <i class="fas fa-fingerprint mr-2"></i>Validar Huella
                            </button>
                        </div>
                        
                        <div id="status-huella" class="p-3 rounded-md bg-gray-100 text-gray-600 text-center">
                            Seleccione un beneficiario para validar su huella
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

                <!-- Campo oculto para validación -->
                <input type="hidden" name="huella_validada" id="huella_validada" value="true">
            </form>
        </div>
    </div>

    <!-- Script de Validación de Huella -->
    <script>
        console.log('=== SCRIPT DE VALIDACIÓN DE HUELLA CARGADO ===');
        
        // Variables globales
        let secugen_lic = "";
        let beneficiarioSeleccionado = null;
        let huellaValidada = false;
        
        // Elementos del DOM
        const beneficiarioSelect = document.getElementById('beneficiario_id');
        const btnValidarHuella = document.getElementById('btn-validar-huella');
        const btnGuardar = document.getElementById('btn-guardar');
        const statusHuella = document.getElementById('status-huella');
        const infoBeneficiario = document.getElementById('info-beneficiario');
        const beneficiarioInfo = document.getElementById('beneficiario-info');
        const huellaValidadaField = document.getElementById('huella_validada');
        
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
                        reject(new Error("No se pudo conectar con el servicio del lector. Estado: " + status));
                    }
                );
            });
        }
        
        // Función para COMPARAR dos huellas (SDK SecuGen)
        function CallSGIMatch(template1, template2, successCall, failCall) {
            const uri = "https://localhost:8443/SGIMatchScore";
            console.log('Iniciando comparación de huellas...');
            
            const xmlhttp = new XMLHttpRequest();
            
            xmlhttp.onreadystatechange = function () {
                console.log('Estado de la comparación:', xmlhttp.readyState, 'HTTP Status:', xmlhttp.status);
                
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    console.log('Respuesta de comparación recibida');
                    console.log('Contenido de la respuesta:', xmlhttp.responseText);
                    
                    try {
                        const fpobject = JSON.parse(xmlhttp.responseText);
                        console.log('JSON de comparación parseado:', fpobject);
                        successCall(fpobject);
                    } catch (parseError) {
                        console.error('Error al parsear JSON de comparación:', parseError);
                        failCall(xmlhttp.status);
                    }
                } else if (xmlhttp.readyState == 4 && xmlhttp.status != 200) {
                    console.error('Error HTTP en comparación:', xmlhttp.status, xmlhttp.statusText);
                    failCall(xmlhttp.status);
                }
            };
            
            xmlhttp.onerror = function () { 
                console.error('Error de red en la comparación');
                failCall(xmlhttp.status); 
            };
            
            xmlhttp.ontimeout = function () {
                console.error('Timeout en la comparación');
                failCall(408);
            };
            
            let params = "template1=" + encodeURIComponent(template1);
            params += "&template2=" + encodeURIComponent(template2);
            params += "&licstr=" + encodeURIComponent(secugen_lic);
            params += "&templateFormat=ISO";
            
            console.log('Parámetros de comparación:', params);
            
            xmlhttp.open("POST", uri, true);
            xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xmlhttp.timeout = 15000;
            
            console.log('Enviando solicitud de comparación...');
            xmlhttp.send(params);
        }
        
        // Función para comparar huellas
        function compararHuellas(plantillaGuardada, plantillaViva) {
            return new Promise((resolve, reject) => {
                console.log('Ejecutando comparación de huellas...');
                
                CallSGIMatch(plantillaGuardada, plantillaViva,
                    (result) => {
                        console.log('Resultado de comparación:', result);
                        console.log('ErrorCode:', result.ErrorCode);
                        console.log('MatchingScore:', result.MatchingScore);
                        
                        if (result.ErrorCode == 0) {
                            console.log('Comparación exitosa');
                            resolve(result.MatchingScore);
                        } else {
                            console.error('Error en la comparación. Código:', result.ErrorCode);
                            reject(new Error("Error durante la comparación. Código: " + result.ErrorCode));
                        }
                    },
                    (status) => {
                        console.error('Error de conexión en comparación. Estado HTTP:', status);
                        reject(new Error("No se pudo conectar con el servicio de comparación. Estado: " + status));
                    }
                );
            });
        }
        
        // Función para obtener huella del beneficiario
        async function obtenerHuellaBeneficiario(beneficiarioId) {
            try {
                console.log('Obteniendo huella del beneficiario:', beneficiarioId);
                
                const response = await fetch(`/beneficiarios/${beneficiarioId}/huella`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    }
                });
                
                const result = await response.json();
                console.log('Respuesta del servidor:', result);
                
                if (result.success && result.huella_template) {
                    console.log('Huella obtenida exitosamente');
                    return result.huella_template;
                } else {
                    throw new Error(result.message || 'No se pudo obtener la huella del beneficiario');
                }
                
            } catch (error) {
                console.error('Error al obtener huella:', error);
                throw error;
            }
        }
        
        // Función principal de validación
        async function validarHuellaBeneficiario() {
            console.log('=== INICIANDO VALIDACIÓN DE HUELLA ===');
            console.log('Timestamp:', new Date().toISOString());
            
            try {
                if (!beneficiarioSeleccionado) {
                    showMessage('Error: Debe seleccionar un beneficiario primero', true);
                    return;
                }
                
                showMessage('Obteniendo huella registrada del beneficiario...', false);
                
                // Obtener huella guardada del beneficiario
                const huellaGuardada = await obtenerHuellaBeneficiario(beneficiarioSeleccionado);
                
                if (!huellaGuardada) {
                    showMessage('Error: El beneficiario no tiene huella registrada', true);
                    return;
                }
                
                console.log('Huella guardada obtenida, longitud:', huellaGuardada.length);
                
                showMessage('Coloque el dedo en el lector para validar...', false);
                
                // Capturar huella actual
                const huellaActual = await capturarHuella();
                
                console.log('=== CAPTURA EXITOSA ===');
                console.log('Longitud de la huella capturada:', huellaActual ? huellaActual.length : 'null');
                
                showMessage('Comparando huellas...', false);
                
                // Comparar huellas
                const puntaje = await compararHuellas(huellaGuardada, huellaActual);
                
                console.log('=== COMPARACIÓN COMPLETADA ===');
                console.log('Puntaje de coincidencia:', puntaje);
                
                const UMBRAL_DE_COINCIDENCIA = 120; // Umbral de seguridad
                
                if (puntaje >= UMBRAL_DE_COINCIDENCIA) {
                    showMessage(`¡Validación exitosa! Coincidencia: ${puntaje} puntos`, false);
                    
                    // Marcar como validado
                    huellaValidada = true;
                    huellaValidadaField.value = 'true';
                    btnGuardar.disabled = false;
                    
                    console.log('Huella validada exitosamente');
                } else {
                    showMessage(`Error: La huella no coincide. Puntaje: ${puntaje} (mínimo requerido: ${UMBRAL_DE_COINCIDENCIA})`, true);
                    
                    // Marcar como no validado
                    huellaValidada = false;
                    huellaValidadaField.value = 'false';
                    btnGuardar.disabled = true;
                }
                
            } catch (error) {
                console.error('=== ERROR EN VALIDACIÓN ===');
                console.error('Tipo de error:', error.constructor.name);
                console.error('Mensaje de error:', error.message);
                console.error('Stack trace:', error.stack);
                
                showMessage(`Error: ${error.message}`, true);
                
                // Marcar como no validado
                huellaValidada = false;
                huellaValidadaField.value = 'false';
                btnGuardar.disabled = true;
            }
        }
        
        // Event listeners
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Configurando event listeners');
            
            // Listener para cambios en el select de beneficiario
            beneficiarioSelect.addEventListener('change', function() {
                if (this.value) {
                    beneficiarioSeleccionado = this.value;
                    const selectedOption = this.options[this.selectedIndex];
                    const nombre = selectedOption.getAttribute('data-nombre');
                    const codigo = selectedOption.getAttribute('data-codigo');
                    
                    // Mostrar información del beneficiario
                    beneficiarioInfo.innerHTML = `
                        <strong>Código:</strong> ${codigo}<br>
                        <strong>Nombre:</strong> ${nombre}
                    `;
                    infoBeneficiario.classList.remove('hidden');
                    
                    // Habilitar botón de validación
                    btnValidarHuella.disabled = false;
                    showMessage('Haga clic en "Validar Huella" para verificar la identidad', false);
                } else {
                    beneficiarioSeleccionado = null;
                    infoBeneficiario.classList.add('hidden');
                    btnValidarHuella.disabled = true;
                    btnGuardar.disabled = true;
                    huellaValidada = false;
                    huellaValidadaField.value = 'false';
                    showMessage('Seleccione un beneficiario para validar su huella', false);
                }
            });
            
            // Listener para el botón de validación
            btnValidarHuella.addEventListener('click', function() {
                validarHuellaBeneficiario();
            });
        });
        
        console.log('Script de validación de huella configurado completamente');
    </script>
</body>
</html>
