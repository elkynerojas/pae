<script>
console.log('=== SCRIPT DE VALIDACIÓN DE HUELLA CARGADO ===');

// Variables globales
let secugen_lic = "";
let beneficiarioSeleccionado = null;
let huellaGuardada = null;

// Función para mostrar mensajes
function showMessage(message, isError = false) {
    const statusElement = document.getElementById('statusHuellaValidacion');
    if (statusElement) {
        statusElement.textContent = message;
        statusElement.className = 'p-3 rounded-md ' + (isError ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600');
    } else {
        console.log('Mensaje:', message, isError ? '(ERROR)' : '(SUCCESS)');
    }
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
        // Obtener el beneficiario seleccionado
        const beneficiarioSelect = document.querySelector('select[name="beneficiario_id"]');
        if (!beneficiarioSelect || !beneficiarioSelect.value) {
            showMessage('Error: Debe seleccionar un beneficiario primero', true);
            return;
        }
        
        const beneficiarioId = beneficiarioSelect.value;
        console.log('Beneficiario seleccionado:', beneficiarioId);
        
        // Actualizar información del beneficiario
        const infoElement = document.querySelector('[data-field="info_beneficiario"] .fi-fo-placeholder-content');
        if (infoElement) {
            const beneficiarioText = beneficiarioSelect.options[beneficiarioSelect.selectedIndex].text;
            infoElement.textContent = `Validando huella para: ${beneficiarioText}`;
        }
        
        showMessage('Obteniendo huella registrada del beneficiario...', false);
        
        // Obtener huella guardada del beneficiario
        const huellaGuardada = await obtenerHuellaBeneficiario(beneficiarioId);
        
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
            const huellaValidadaField = document.querySelector('input[name="huella_validada"]');
            if (huellaValidadaField) {
                huellaValidadaField.value = 'true';
            }
            
            console.log('Huella validada exitosamente');
        } else {
            showMessage(`Error: La huella no coincide. Puntaje: ${puntaje} (mínimo requerido: ${UMBRAL_DE_COINCIDENCIA})`, true);
            
            // Marcar como no validado
            const huellaValidadaField = document.querySelector('input[name="huella_validada"]');
            if (huellaValidadaField) {
                huellaValidadaField.value = 'false';
            }
        }
        
    } catch (error) {
        console.error('=== ERROR EN VALIDACIÓN ===');
        console.error('Tipo de error:', error.constructor.name);
        console.error('Mensaje de error:', error.message);
        console.error('Stack trace:', error.stack);
        
        showMessage(`Error: ${error.message}`, true);
        
        // Marcar como no validado
        const huellaValidadaField = document.querySelector('input[name="huella_validada"]');
        if (huellaValidadaField) {
            huellaValidadaField.value = 'false';
        }
    }
}

// Hacer la función global
window.validarHuellaBeneficiario = validarHuellaBeneficiario;

// Actualizar información del beneficiario cuando se selecciona
document.addEventListener('DOMContentLoaded', function() {
    console.log('Configurando listeners para validación de huella');
    
    // Listener para cambios en el select de beneficiario
    const beneficiarioSelect = document.querySelector('select[name="beneficiario_id"]');
    if (beneficiarioSelect) {
        beneficiarioSelect.addEventListener('change', function() {
            const infoElement = document.querySelector('[data-field="info_beneficiario"] .fi-fo-placeholder-content');
            if (infoElement && this.value) {
                const beneficiarioText = this.options[this.selectedIndex].text;
                infoElement.textContent = `Beneficiario seleccionado: ${beneficiarioText}`;
                showMessage('Seleccione un beneficiario para validar su huella', false);
            } else if (infoElement) {
                infoElement.textContent = '';
                showMessage('Seleccione un beneficiario para validar su huella', false);
            }
        });
    }
});

console.log('Script de validación de huella configurado completamente');
</script>
