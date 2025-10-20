// Huella Digital Component para Filament
// Adaptado del archivo original huella.js para funcionar con Filament

document.addEventListener('DOMContentLoaded', function() {
    // Verificar si existe el componente de huella digital en la página
    if (!document.querySelector('[x-data*="huellaDigitalComponent"]')) {
        return;
    }

    // =================================================================================
    // CONFIGURACIÓN DEL SDK SECUGEN
    // =================================================================================

    const SECUGEN_CONFIG = {
        licencia: "", // Licencia del SDK (vacía para modo de prueba)
        timeout: 10000,
        calidad: 50,
        formato: "ISO",
        umbralCoincidencia: 120
    };

    // =================================================================================
    // FUNCIONES DEL SDK SECUGEN
    // =================================================================================

    /**
     * Captura una huella digital usando el SDK de SecuGen
     */
    function capturarHuellaSDK() {
        return new Promise((resolve, reject) => {
            const uri = "https://localhost:8443/SGIFPCapture";
            const xmlhttp = new XMLHttpRequest();

            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    try {
                        const fpobject = JSON.parse(xmlhttp.responseText);
                        if (fpobject.ErrorCode == 0) {
                            resolve(fpobject.TemplateBase64);
                        } else {
                            reject(new Error("Error en la captura. Código: " + fpobject.ErrorCode));
                        }
                    } catch (e) {
                        reject(new Error("Error al procesar la respuesta del lector"));
                    }
                } else if (xmlhttp.readyState == 4 && xmlhttp.status != 200) {
                    reject(new Error("No se pudo conectar con el servicio del lector. Estado: " + xmlhttp.status));
                }
            };

            xmlhttp.onerror = function () {
                reject(new Error("Error de conexión con el lector biométrico"));
            };

            const params = new URLSearchParams({
                Timeout: SECUGEN_CONFIG.timeout,
                Quality: SECUGEN_CONFIG.calidad,
                licstr: SECUGEN_CONFIG.licencia,
                templateFormat: SECUGEN_CONFIG.formato
            });

            xmlhttp.open("POST", uri, true);
            xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xmlhttp.send(params);
        });
    }

    /**
     * Compara dos huellas digitales
     */
    function compararHuellasSDK(template1, template2) {
        return new Promise((resolve, reject) => {
            const uri = "https://localhost:8443/SGIMatchScore";
            const xmlhttp = new XMLHttpRequest();

            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    try {
                        const fpobject = JSON.parse(xmlhttp.responseText);
                        if (fpobject.ErrorCode == 0) {
                            resolve(fpobject.MatchingScore);
                        } else {
                            reject(new Error("Error durante la comparación. Código: " + fpobject.ErrorCode));
                        }
                    } catch (e) {
                        reject(new Error("Error al procesar la respuesta de comparación"));
                    }
                } else if (xmlhttp.readyState == 4 && xmlhttp.status != 200) {
                    reject(new Error("No se pudo conectar con el servicio de comparación. Estado: " + xmlhttp.status));
                }
            };

            xmlhttp.onerror = function () {
                reject(new Error("Error de conexión con el servicio de comparación"));
            };

            const params = new URLSearchParams({
                template1: template1,
                template2: template2,
                licstr: SECUGEN_CONFIG.licencia,
                templateFormat: SECUGEN_CONFIG.formato
            });

            xmlhttp.open("POST", uri, true);
            xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xmlhttp.send(params);
        });
    }

    // =================================================================================
    // FUNCIONES AUXILIARES
    // =================================================================================

    /**
     * Muestra notificaciones de Filament
     */
    function mostrarNotificacion(titulo, mensaje, tipo = 'info') {
        if (window.$wire && window.$wire.$dispatch) {
            window.$wire.$dispatch('notify', {
                title: titulo,
                body: mensaje,
                type: tipo
            });
        } else {
            // Fallback para notificaciones nativas
            console.log(`${tipo.toUpperCase()}: ${titulo} - ${mensaje}`);
        }
    }

    /**
     * Verifica si una huella ya existe en el sistema
     */
    async function verificarHuellaExistente(template) {
        try {
            const response = await fetch('/api/verificar-huella-existente', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify({ template: template })
            });

            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Error verificando huella existente:', error);
            return { success: false, message: 'Error al verificar la huella' };
        }
    }

    // =================================================================================
    // COMPONENTE ALPINE.JS GLOBAL
    // =================================================================================

    // Hacer disponible el componente globalmente para Alpine.js
    window.huellaDigitalComponent = function(statePath, initialValue) {
        return {
            huellaTemplate: initialValue || '',
            capturando: false,
            huellaRegistrada: !!initialValue,
            mensaje: '',
            tipoMensaje: 'info',

            async capturarHuella() {
                this.capturando = true;
                this.mensaje = 'Coloque el dedo en el lector para capturar...';
                this.tipoMensaje = 'info';

                try {
                    // Capturar la huella usando el SDK
                    const template = await capturarHuellaSDK();

                    this.mensaje = 'Verificando si la huella ya existe...';
                    this.tipoMensaje = 'info';

                    // Verificar si la huella ya existe
                    const verificacion = await verificarHuellaExistente(template);

                    if (!verificacion.success) {
                        throw new Error(verificacion.message);
                    }

                    if (verificacion.existe) {
                        throw new Error(verificacion.message);
                    }

                    // Si llegamos aquí, la huella es única
                    this.huellaTemplate = template;
                    this.huellaRegistrada = true;
                    this.mensaje = 'Huella capturada y verificada correctamente';
                    this.tipoMensaje = 'success';

                    // Disparar evento para que Filament detecte el cambio
                    this.$dispatch('input', this.huellaTemplate);

                    // Mostrar notificación de éxito
                    mostrarNotificacion('Huella Digital', 'Huella registrada correctamente', 'success');

                } catch (error) {
                    this.mensaje = error.message;
                    this.tipoMensaje = 'error';
                    console.error('Error capturando huella:', error);

                    // Mostrar notificación de error
                    mostrarNotificacion('Error', error.message, 'danger');
                } finally {
                    this.capturando = false;
                }
            },

            limpiarHuella() {
                this.huellaTemplate = '';
                this.huellaRegistrada = false;
                this.mensaje = '';
                this.tipoMensaje = 'info';

                // Disparar evento para que Filament detecte el cambio
                this.$dispatch('input', '');

                // Mostrar notificación
                mostrarNotificacion('Huella Digital', 'Huella eliminada correctamente', 'info');
            },

            // Función para verificar el estado del lector
            async verificarLector() {
                try {
                    this.mensaje = 'Verificando conexión con el lector...';
                    this.tipoMensaje = 'info';

                    // Intentar una captura de prueba
                    await capturarHuellaSDK();

                    this.mensaje = 'Lector biométrico conectado correctamente';
                    this.tipoMensaje = 'success';
                } catch (error) {
                    this.mensaje = 'No se pudo conectar con el lector biométrico. Verifique que esté encendido y conectado.';
                    this.tipoMensaje = 'error';
                }
            }
        };
    };

    // =================================================================================
    // INICIALIZACIÓN
    // =================================================================================

    // Verificar el estado del lector al cargar la página
    setTimeout(() => {
        const huellaComponents = document.querySelectorAll('[x-data*="huellaDigitalComponent"]');
        huellaComponents.forEach(component => {
            // Aquí podrías agregar lógica adicional de inicialización si es necesario
        });
    }, 1000);

    console.log('Componente de Huella Digital para Filament cargado correctamente');
});

// =================================================================================
// UTILIDADES ADICIONALES
// =================================================================================

/**
 * Función para verificar el estado del servicio de huella digital
 */
window.verificarServicioHuella = async function() {
    try {
        const response = await fetch('/api/obtener-todas-plantillas');
        const data = await response.json();

        if (data.success) {
            console.log(`Servicio de huella digital funcionando. ${data.count} plantillas registradas.`);
            return true;
        } else {
            console.error('Error en el servicio de huella digital:', data.message);
            return false;
        }
    } catch (error) {
        console.error('No se pudo conectar con el servicio de huella digital:', error);
        return false;
    }
};

// Verificar el servicio al cargar
document.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
        window.verificarServicioHuella();
    }, 2000);
});
