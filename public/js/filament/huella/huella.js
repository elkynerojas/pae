// app.js - VERSIÓN FINAL COMPLETA

console.log('=== ARCHIVO HUELLA.JS CARGADO ===');
console.log('Timestamp:', new Date().toISOString());

// =================================================================================
// FUNCIONES GLOBALES (fuera de DOMContentLoaded para disponibilidad inmediata)
// =================================================================================

// Función global para mostrar mensajes
window.showMessage = function(message, isError = false) {
    const statusMessages = document.getElementById('statusMessages');
    if (statusMessages) {
        statusMessages.textContent = message;
        statusMessages.className = 'status';
        if (isError) {
            statusMessages.classList.add('status-error');
        } else {
            statusMessages.classList.add('status-success');
        }
    } else {
        console.log('Mensaje:', message, isError ? '(ERROR)' : '(SUCCESS)');
    }
};

// Función global para manejar el clic del botón
window.capturarHuellaClick = async function() {
    console.log('=== CAPTURAR HUELLA CLICK EJECUTADO ===');
    console.log('Timestamp:', new Date().toISOString());
    
    try {
        // Verificar si el elemento de mensajes existe
        const statusElement = document.getElementById('statusMessages');
        if (!statusElement) {
            console.error('Elemento statusMessages no encontrado');
            alert('Error: Elemento de mensajes no encontrado');
            return;
        }
        
        console.log('Elemento de mensajes encontrado:', statusElement);
        
        // Verificar si la función showMessage existe
        if (typeof window.showMessage === 'function') {
            window.showMessage('Iniciando captura de huella...', false);
        } else {
            console.log('Función showMessage no disponible, usando console.log');
        }
        
        console.log('Mensaje inicial mostrado');
        
        // Mostrar mensaje de instrucciones
        if (typeof window.showMessage === 'function') {
            window.showMessage('Coloque el dedo en el lector y espere...', false);
        }
        console.log('Solicitando captura al lector...');
        
        // Verificar si la función capturarHuella existe
        if (typeof window.capturarHuella !== 'function') {
            throw new Error('Función capturarHuella no está disponible');
        }
        
        // Capturar la huella
        const huella = await window.capturarHuella();
        
        console.log('=== CAPTURA EXITOSA ===');
        console.log('Longitud de la huella capturada:', huella ? huella.length : 'null');
        console.log('Primeros 50 caracteres:', huella ? huella.substring(0, 50) + '...' : 'null');
        
        if (typeof window.showMessage === 'function') {
            window.showMessage('¡Huella capturada exitosamente!', false);
            
            // Mostrar información adicional
            setTimeout(() => {
                window.showMessage(`Huella capturada: ${huella.length} caracteres`, false);
            }, 2000);
        }
        
    } catch (error) {
        console.error('=== ERROR EN CAPTURA ===');
        console.error('Tipo de error:', error.constructor.name);
        console.error('Mensaje de error:', error.message);
        console.error('Stack trace:', error.stack);
        
        // Mostrar error al usuario
        if (typeof window.showMessage === 'function') {
            window.showMessage(`Error: ${error.message}`, true);
        } else {
            alert(`Error: ${error.message}`);
        }
        
        // Información adicional para debugging
        console.log('Verificando conexión con el lector...');
        console.log('URL del servicio:', 'https://localhost:8443/SGIFPCapture');
    }
};

// Función para configurar event listeners del modal
window.configurarModalHuella = function() {
    console.log('=== CONFIGURANDO MODAL DE HUELLA ===');
    
    // Buscar el botón por ID
    const btnVerificar = document.getElementById('btnVerificar');
    console.log('Botón btnVerificar encontrado:', btnVerificar);
    
    if (btnVerificar) {
        // Remover cualquier listener existente
        btnVerificar.removeAttribute('onclick');
        
        // Agregar nuevo event listener
        btnVerificar.addEventListener('click', function(e) {
            console.log('=== CLICK EN BOTÓN CAPTURAR HUELLA ===');
            e.preventDefault();
            e.stopPropagation();
            
            if (typeof window.capturarHuellaClick === 'function') {
                console.log('Ejecutando capturarHuellaClick...');
                window.capturarHuellaClick();
            } else {
                console.error('Función capturarHuellaClick no está disponible');
                alert('Error: Función de captura no está disponible');
            }
        });
        
        console.log('Event listener configurado exitosamente');
        return true;
    } else {
        console.error('Botón btnVerificar no encontrado');
        return false;
    }
};

// Función para manejar el clic del botón (versión simple)
window.testClick = function() {
    console.log('=== TEST CLICK EJECUTADO ===');
    alert('¡El botón funciona! Ahora probando la función de captura...');
    
    if (typeof window.capturarHuellaClick === 'function') {
        console.log('Ejecutando capturarHuellaClick...');
        window.capturarHuellaClick();
    } else {
        console.error('Función capturarHuellaClick no está disponible');
        alert('Error: Función de captura no está disponible');
    }
};

// Configurar automáticamente cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOMContentLoaded - Configurando modal de huella');
    window.configurarModalHuella();
});

// También configurar con un delay para contenido dinámico
setTimeout(function() {
    console.log('Timeout - Configurando modal de huella dinámicamente');
    window.configurarModalHuella();
}, 2000);

// Función original (mantener para compatibilidad)
window.capturarHuellaClickOriginal = async function() {
    console.log('=== INICIANDO CAPTURA DE HUELLA ===');
    console.log('Timestamp:', new Date().toISOString());
    
    try {
        // Verificar si el elemento de mensajes existe
        const statusElement = document.getElementById('statusMessages');
        if (!statusElement) {
            console.error('Elemento statusMessages no encontrado');
            alert('Error: Elemento de mensajes no encontrado');
            return;
        }
        
        console.log('Elemento de mensajes encontrado:', statusElement);
        
        // Verificar si la función showMessage existe
        if (typeof window.showMessage === 'function') {
            window.showMessage('Iniciando captura de huella...', false);
        } else {
            console.log('Función showMessage no disponible, usando console.log');
        }
        
        console.log('Mensaje inicial mostrado');
        
        // Mostrar mensaje de instrucciones
        if (typeof window.showMessage === 'function') {
            window.showMessage('Coloque el dedo en el lector y espere...', false);
        }
        console.log('Solicitando captura al lector...');
        
        // Verificar si la función capturarHuella existe
        if (typeof window.capturarHuella !== 'function') {
            throw new Error('Función capturarHuella no está disponible');
        }
        
        // Capturar la huella
        const huella = await window.capturarHuella();
        
        console.log('=== CAPTURA EXITOSA ===');
        console.log('Longitud de la huella capturada:', huella ? huella.length : 'null');
        console.log('Primeros 50 caracteres:', huella ? huella.substring(0, 50) + '...' : 'null');
        
        if (typeof window.showMessage === 'function') {
            window.showMessage('¡Huella capturada exitosamente!', false);
            
            // Mostrar información adicional
            setTimeout(() => {
                window.showMessage(`Huella capturada: ${huella.length} caracteres`, false);
            }, 2000);
        }
        
    } catch (error) {
        console.error('=== ERROR EN CAPTURA ===');
        console.error('Tipo de error:', error.constructor.name);
        console.error('Mensaje de error:', error.message);
        console.error('Stack trace:', error.stack);
        
        // Mostrar error al usuario
        if (typeof window.showMessage === 'function') {
            window.showMessage(`Error: ${error.message}`, true);
        } else {
            alert(`Error: ${error.message}`);
        }
        
        // Información adicional para debugging
        console.log('Verificando conexión con el lector...');
        console.log('URL del servicio:', 'https://localhost:8443/SGIFPCapture');
    }
};

document.addEventListener('DOMContentLoaded', () => {
    // =================================================================================
    // PASO 1: CÓDIGO DEL SDK (CAPTURA Y COMPARACIÓN)
    // =================================================================================

    // Esta variable de licencia puedes dejarla vacía, el SDK la maneja en modo de prueba.
    let secugen_lic = ""; 

    // Función para CAPTURAR una huella (de Demo1.aspx)
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
            failCall(408); // Request Timeout
        };
        
        let params = "Timeout=10000&Quality=50&licstr=" + encodeURIComponent(secugen_lic) + "&templateFormat=ISO";
        console.log('Parámetros a enviar:', params);
        
        xmlhttp.open("POST", uri, true);
        xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xmlhttp.timeout = 15000; // 15 segundos timeout
        
        console.log('Enviando solicitud HTTP...');
        xmlhttp.send(params);
    }

    // Función para COMPARAR dos huellas (de Demo3.aspx)
    function CallSGIMatch(template1, template2, successCall, failCall) {
        const uri = "https://localhost:8443/SGIMatchScore";
        const xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                const fpobject = JSON.parse(xmlhttp.responseText);
                successCall(fpobject);
            } else if (xmlhttp.readyState == 4 && xmlhttp.status != 200) {
                failCall(xmlhttp.status);
            }
        };
        xmlhttp.onerror = function () { failCall(xmlhttp.status); };
        let params = "template1=" + encodeURIComponent(template1);
        params += "&template2=" + encodeURIComponent(template2);
        params += "&licstr=" + encodeURIComponent(secugen_lic);
        params += "&templateFormat=" + "ISO";
        xmlhttp.open("POST", uri, true);
        xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xmlhttp.send(params);
    }

    // =================================================================================
    // PASO 2: FUNCIONES "TRADUCTORAS" (PROMISES) PARA USAR CON ASYNC/AWAIT
    // =================================================================================
    
    // Traductor para la captura
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

    // Hacer la función accesible globalmente
    window.capturarHuella = capturarHuella;

    // Traductor para la comparación
    function compararHuellas(plantillaGuardada, plantillaViva) {
        return new Promise((resolve, reject) => {
            CallSGIMatch(plantillaGuardada, plantillaViva,
                (result) => {
                    if (result.ErrorCode == 0) resolve(result.MatchingScore);
                    else reject(new Error("Error durante la comparación. Código: " + result.ErrorCode));
                },
                (status) => reject(new Error("No se pudo conectar con el servicio de comparación. Estado: " + status))
            );
        });
    }

    // =================================================================================
    // PASO 3: LÓGICA DE NUESTRA APLICACIÓN
    // =================================================================================

    const btnRegistrar = document.getElementById('btnRegistrar');
    const btnVerificar = document.getElementById('btnVerificar');
    const statusMessages = document.getElementById('statusMessages');

    // Manejador para el botón de registro (CON VERIFICACIÓN DE DUPLICADOS)
    btnRegistrar.addEventListener('click', async () => {
        const nombre = document.getElementById('nombre').value.trim();
        const documento = document.getElementById('documentoRegistro').value.trim();
        if (!nombre || !documento) {
            showMessage('Por favor, complete los campos de nombre y documento.', true);
            return;
        }

        try {
            // 1. Capturamos la nueva huella
            showMessage('Coloque el dedo en el lector para registrar...', false);
            const huellaNueva = await capturarHuella(); 

            // 2. Obtenemos TODAS las huellas de la base de datos
            showMessage('Verificando si la huella ya existe...', false);
            const resExistentes = await fetch('obtener_todas_plantillas.php');
            const dataExistentes = await resExistentes.json();

            if (!dataExistentes.success) {
                throw new Error(dataExistentes.message);
            }
            const plantillasExistentes = dataExistentes.templates;

            // 3. Comparamos la huella nueva contra cada una de las existentes
            let huellaYaExiste = false;
            const UMBRAL_DE_COINCIDENCIA = 120; // Umbral de seguridad para considerar una coincidencia

            for (const plantillaGuardada of plantillasExistentes) {
                const puntaje = await compararHuellas(plantillaGuardada, huellaNueva);
                if (puntaje >= UMBRAL_DE_COINCIDENCIA) {
                    huellaYaExiste = true;
                    break; // Si encontramos una coincidencia, no necesitamos seguir buscando
                }
            }

            // 4. Decidimos si registrar o mostrar un error
            if (huellaYaExiste) {
                throw new Error("Esta huella ya ha sido registrada por otro estudiante.");
            }

            // 5. Si la huella es única, procedemos con el registro normal
            showMessage('Huella única. Registrando en el sistema...', false);
            const response = await fetch('registrar.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ nombre, documento, huella: huellaNueva })
            });

            const result = await response.json();
            if (result.success) {
                showMessage(result.message, false);
                document.getElementById('nombre').value = '';
                document.getElementById('documentoRegistro').value = '';
            } else {
                showMessage(result.message, true);
            }
        } catch (error) {
            showMessage(error.message, true);
            console.error('Error en registro:', error);
        }
    });
    
    // Manejador para el botón de verificación (LÓGICA FINAL)
    btnVerificar.addEventListener('click', async () => {
        const documento = document.getElementById('documentoVerificacion').value.trim();
        if (!documento) {
            showMessage('Por favor, ingrese el documento a verificar.', true);
            return;
        }

        try {
            // 1. Capturamos la huella en vivo
            showMessage('Coloque el dedo en el lector para verificar...', false);
            const huellaViva = await capturarHuella();

            // 2. Pedimos a PHP la huella guardada
            showMessage('Obteniendo plantilla de la base de datos...', false);
            const resPlantilla = await fetch(`obtener_plantilla.php?documento=${documento}`);
            const dataPlantilla = await resPlantilla.json();

            if (!dataPlantilla.success) {
                throw new Error(dataPlantilla.message);
            }
            const huellaGuardada = dataPlantilla.template;

            // 3. Usamos el SDK para comparar las huellas
            showMessage('Comparando huellas...', false);
            const puntaje = await compararHuellas(huellaGuardada, huellaViva);

            // 4. Verificamos si el puntaje es suficiente
            const UMBRAL_DE_COINCIDENCIA = 120;
            if (puntaje >= UMBRAL_DE_COINCIDENCIA) {
                // 5. Si coinciden, le pedimos a PHP que registre la entrega
                showMessage(`¡Coincidencia exitosa! (Puntaje: ${puntaje}). Registrando entrega...`, false);
                const resEntrega = await fetch('registrar_entrega.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ documento: documento })
                });
                const dataEntrega = await resEntrega.json();
                if (dataEntrega.success) {
                    showMessage(dataEntrega.message, false);
                } else {
                    throw new Error(dataEntrega.message);
                }
            } else {
                showMessage(`La huella no coincide. (Puntaje: ${puntaje})`, true);
            }
        } catch (error) {
            showMessage(error.message, true);
            console.error('Error en verificación:', error);
        }
    });

    // Función showMessage ya está definida globalmente arriba
});