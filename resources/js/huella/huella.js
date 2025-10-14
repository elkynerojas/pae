// app.js - VERSIÓN FINAL COMPLETA

document.addEventListener('DOMContentLoaded', () => {
    // =================================================================================
    // PASO 1: CÓDIGO DEL SDK (CAPTURA Y COMPARACIÓN)
    // =================================================================================

    // Esta variable de licencia puedes dejarla vacía, el SDK la maneja en modo de prueba.
    let secugen_lic = ""; 

    // Función para CAPTURAR una huella (de Demo1.aspx)
    function CallSGIFPGetData(successCall, failCall) {
        const uri = "https://localhost:8443/SGIFPCapture";
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
        let params = "Timeout=10000&Quality=50&licstr=" + encodeURIComponent(secugen_lic) + "&templateFormat=ISO";
        xmlhttp.open("POST", uri, true);
        xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
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
            CallSGIFPGetData(
                (result) => {
                    if (result.ErrorCode == 0) resolve(result.TemplateBase64);
                    else reject(new Error("Error en la captura. Código: " + result.ErrorCode));
                },
                (status) => reject(new Error("No se pudo conectar con el servicio del lector. Estado: " + status))
            );
        });
    }

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

    // Función para mostrar mensajes de estado (sin cambios)
    function showMessage(message, isError = false) {
        statusMessages.textContent = message;
        statusMessages.className = 'status';
        if (isError) {
            statusMessages.classList.add('status-error');
        } else {
            statusMessages.classList.add('status-success');
        }
    }
});