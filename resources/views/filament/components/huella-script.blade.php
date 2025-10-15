<script>
console.log('=== SCRIPT DE HUELLA CARGADO ===');

// Variables globales
let secugen_lic = "";

// Función para mostrar mensajes
function showMessage(message, isError = false) {
    const statusElement = document.getElementById('statusHuella');
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

// Función principal de captura
async function capturarHuellaDactilar() {
    console.log('=== INICIANDO CAPTURA DE HUELLA ===');
    console.log('Timestamp:', new Date().toISOString());
    
    try {
        showMessage('Iniciando captura de huella...', false);
        console.log('Mensaje inicial mostrado');
        
        // Mostrar mensaje de instrucciones
        showMessage('Coloque el dedo en el lector y espere...', false);
        console.log('Solicitando captura al lector...');
        
        // Capturar la huella
        const huella = await capturarHuella();
        
        console.log('=== CAPTURA EXITOSA ===');
        console.log('Longitud de la huella capturada:', huella ? huella.length : 'null');
        console.log('Primeros 50 caracteres:', huella ? huella.substring(0, 50) + '...' : 'null');
        
        showMessage('Huella capturada exitosamente!', false);
        
        // Llenar el campo de huella en el formulario
        const huellaField = document.querySelector('textarea[name="huella_template"]') || 
                           document.querySelector('textarea[data-field="huella_template"]') ||
                           document.querySelector('textarea[id*="huella_template"]');
        
        if (huellaField) {
            huellaField.value = huella;
            console.log('Campo de huella llenado exitosamente');
            
            // También intentar disparar eventos para que Filament detecte el cambio
            huellaField.dispatchEvent(new Event('input', { bubbles: true }));
            huellaField.dispatchEvent(new Event('change', { bubbles: true }));
        } else {
            console.error('Campo de huella no encontrado');
            console.log('Intentando selectores alternativos...');
            
            // Buscar todos los textareas para debugging
            const allTextareas = document.querySelectorAll('textarea');
            console.log('Textareas encontrados:', allTextareas.length);
            allTextareas.forEach((textarea, index) => {
                console.log(`Textarea ${index}:`, textarea.name, textarea.id, textarea.className);
            });
        }
        
        // Mostrar información adicional
        setTimeout(() => {
            showMessage(`Huella capturada: ${huella.length} caracteres. Guarde el formulario para almacenar.`, false);
        }, 2000);
        
    } catch (error) {
        console.error('=== ERROR EN CAPTURA ===');
        console.error('Tipo de error:', error.constructor.name);
        console.error('Mensaje de error:', error.message);
        console.error('Stack trace:', error.stack);
        
        // Mostrar error al usuario
        showMessage(`Error: ${error.message}`, true);
        
        // Información adicional para debugging
        console.log('Verificando conexión con el lector...');
        console.log('URL del servicio:', 'https://localhost:8443/SGIFPCapture');
    }
}

// Hacer la función global
window.capturarHuellaDactilar = capturarHuellaDactilar;

console.log('Script de huella configurado completamente');
</script>
