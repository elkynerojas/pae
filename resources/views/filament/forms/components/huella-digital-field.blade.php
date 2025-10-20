@php
    $state = $getState();
    $statePath = $getStatePath();
    $isRequired = $isRequired;
    $isDisabled = $isDisabled;
@endphp

<div
    x-data="huellaDigitalComponent('{{ $statePath }}', '{{ $state }}')"
    x-init="init()"
    class="space-y-4"
>
    <!-- Estado actual de la huella -->
    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div x-show="!huellaRegistrada" class="h-8 w-8 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                        <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <div x-show="huellaRegistrada" class="h-8 w-8 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center">
                        <svg class="h-4 w-4 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                        <span x-show="!huellaRegistrada">Sin huella registrada</span>
                        <span x-show="huellaRegistrada">Huella digital registrada</span>
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        <span x-show="!huellaRegistrada">Capture la huella para autenticación biométrica</span>
                        <span x-show="huellaRegistrada">Lista para verificación en entregas</span>
                    </p>
                </div>
            </div>
            <div class="flex space-x-2">
                <!-- Botón para abrir modal de captura -->
                <button
                    type="button"
                    @click="abrirModal()"
                    :disabled="{{ $isDisabled ? 'true' : 'false' }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed shadow-sm transition-colors duration-200"
                    style="min-width: 140px;"
                >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    <span x-text="huellaRegistrada ? 'Cambiar Huella' : 'Registrar Huella'"></span>
                </button>

                <!-- Botón para limpiar huella -->
                <button
                    x-show="huellaRegistrada"
                    type="button"
                    @click="limpiarHuella()"
                    :disabled="{{ $isDisabled ? 'true' : 'false' }}"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed shadow-sm"
                >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Eliminar
                </button>
            </div>
        </div>
    </div>

    <!-- Modal para captura de huella -->
    <div
        x-show="modalAbierto"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 overflow-y-auto"
        @click.away="cerrarModal()"
    >
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Fondo del modal -->
            <div
                x-show="modalAbierto"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
            ></div>

            <!-- Contenido del modal -->
            <div
                x-show="modalAbierto"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6"
            >
                <!-- Header del modal -->
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">
                        Registro de Huella Digital
                    </h3>
                    <button
                        @click="cerrarModal()"
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Contenido del modal -->
                <div class="text-center">
                    <!-- Icono del lector -->
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-blue-100 dark:bg-blue-900 mb-4">
                        <svg class="h-8 w-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>

                    <!-- Instrucciones -->
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                        Coloque el dedo en el lector biométrico y presione el botón "Capturar Huella"
                    </p>

                    <!-- Botón de captura -->
                    <button
                        type="button"
                        @click="capturarHuella()"
                        :disabled="capturando"
                        :class="{
                            'bg-blue-600 hover:bg-blue-700': !capturando,
                            'bg-gray-400 cursor-not-allowed': capturando
                        }"
                        class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200"
                    >
                        <svg x-show="!capturando" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        <svg x-show="capturando" class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span x-text="capturando ? 'Capturando...' : 'Capturar Huella'"></span>
                    </button>

                    <!-- Mensaje de estado en el modal -->
                    <div x-show="mensaje" class="mt-4 rounded-md p-3" :class="{
                        'bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800': tipoMensaje === 'success',
                        'bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800': tipoMensaje === 'error',
                        'bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800': tipoMensaje === 'info'
                    }">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg x-show="tipoMensaje === 'success'" class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <svg x-show="tipoMensaje === 'error'" class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                                <svg x-show="tipoMensaje === 'info'" class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium" :class="{
                                    'text-green-800 dark:text-green-200': tipoMensaje === 'success',
                                    'text-red-800 dark:text-red-200': tipoMensaje === 'error',
                                    'text-blue-800 dark:text-blue-200': tipoMensaje === 'info'
                                }" x-text="mensaje"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer del modal -->
                <div class="mt-6 flex justify-end space-x-3">
                    <button
                        type="button"
                        @click="cerrarModal()"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    >
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Campo oculto para almacenar la huella -->
    <input
        type="hidden"
        x-model="huellaTemplate"
        @input="console.log('Campo oculto cambió:', $event.target.value.substring(0, 50) + '...'); $dispatch('input', $event.target.value)"
        :name="'{{ $statePath }}'"
        :value="huellaTemplate"
    />

    <!-- Debug: Mostrar el valor actual del campo -->
    <div x-show="huellaTemplate" class="mt-2 p-2 bg-gray-100 dark:bg-gray-700 rounded text-xs">
        <strong>Debug - Valor del campo:</strong>
        <span x-text="huellaTemplate ? huellaTemplate.substring(0, 50) + '...' : 'Vacío'"></span>
    </div>
</div>

@push('scripts')
<script>
function huellaDigitalComponent(statePath, initialValue) {
    console.log('Inicializando huellaDigitalComponent:', { statePath, initialValue });

    return {
        huellaTemplate: initialValue || '',
        capturando: false,
        huellaRegistrada: !!initialValue,
        mensaje: '',
        tipoMensaje: 'info',
        modalAbierto: false,

        init() {
            console.log('Componente huella digital inicializado');
            console.log('StatePath:', '{{ $statePath }}');
            console.log('Initial Value:', '{{ $state }}');
            console.log('Is Required:', {{ $isRequired ? 'true' : 'false' }});
            console.log('Is Disabled:', {{ $isDisabled ? 'true' : 'false' }});
        },

        abrirModal() {
            console.log('Abriendo modal de huella digital');
            this.modalAbierto = true;
            this.mensaje = '';
            this.tipoMensaje = 'info';
        },

        cerrarModal() {
            this.modalAbierto = false;
            this.mensaje = '';
            this.tipoMensaje = 'info';
            this.capturando = false;
        },

        async capturarHuella() {
            this.capturando = true;
            this.mensaje = 'Coloque el dedo en el lector para capturar...';
            this.tipoMensaje = 'info';

            try {
                // 1. Capturar la huella directamente con el SDK de SecuGen
                const huellaNueva = await this.capturarHuellaSDK();

                // 2. Verificar si la huella ya existe
                this.mensaje = 'Verificando si la huella ya existe...';
                this.tipoMensaje = 'info';

                const huellaExiste = await this.verificarHuellaExistente(huellaNueva);

                if (huellaExiste) {
                    throw new Error('Esta huella ya ha sido registrada por otro beneficiario.');
                }

                // 3. Si la huella es única, guardarla
                this.huellaTemplate = huellaNueva;
                this.huellaRegistrada = true;
                this.mensaje = '¡Huella capturada y verificada correctamente!';
                this.tipoMensaje = 'success';

                // Disparar evento para que Filament detecte el cambio
                console.log('Disparando evento input con valor:', this.huellaTemplate.substring(0, 50) + '...');
                this.$dispatch('input', this.huellaTemplate);

                // También actualizar el campo de respaldo
                this.$dispatch('input', this.huellaTemplate, 'huella_template_backup');

                // Debug: Mostrar en consola que se está guardando
                console.log('Huella guardada en el campo:', this.huellaTemplate.substring(0, 50) + '...');

                // Cerrar el modal después de 2 segundos
                setTimeout(() => {
                    this.cerrarModal();
                }, 2000);

            } catch (error) {
                this.mensaje = error.message;
                this.tipoMensaje = 'error';
                console.error('Error capturando huella:', error);
            } finally {
                this.capturando = false;
            }
        },

        // Función para capturar huella usando el SDK de SecuGen (igual que pae3)
        capturarHuellaSDK() {
            return new Promise((resolve, reject) => {
                const secugen_lic = ""; // Licencia vacía para modo de prueba
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

                const params = "Timeout=10000&Quality=50&licstr=" + encodeURIComponent(secugen_lic) + "&templateFormat=ISO";
                xmlhttp.open("POST", uri, true);
                xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xmlhttp.send(params);
            });
        },

        // Función para comparar huellas usando el SDK de SecuGen (igual que pae3)
        compararHuellasSDK(template1, template2) {
            return new Promise((resolve, reject) => {
                const secugen_lic = "";
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

                let params = "template1=" + encodeURIComponent(template1);
                params += "&template2=" + encodeURIComponent(template2);
                params += "&licstr=" + encodeURIComponent(secugen_lic);
                params += "&templateFormat=ISO";

                xmlhttp.open("POST", uri, true);
                xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xmlhttp.send(params);
            });
        },

        // Función para verificar si una huella ya existe
        async verificarHuellaExistente(templateNueva) {
            try {
                // Obtener todas las plantillas existentes
                const response = await fetch('/api/obtener-todas-plantillas', {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    }
                });

                const data = await response.json();

                if (!data.success) {
                    throw new Error(data.message);
                }

                const plantillasExistentes = data.templates;
                const UMBRAL_DE_COINCIDENCIA = 120;

                // Comparar la huella nueva contra cada una existente
                for (const plantillaGuardada of plantillasExistentes) {
                    if (plantillaGuardada) {
                        const puntaje = await this.compararHuellasSDK(plantillaGuardada, templateNueva);
                        if (puntaje >= UMBRAL_DE_COINCIDENCIA) {
                            return true; // La huella ya existe
                        }
                    }
                }

                return false; // La huella es única
            } catch (error) {
                console.error('Error verificando huella existente:', error);
                return false; // En caso de error, permitir el registro
            }
        },


        limpiarHuella() {
            if (confirm('¿Está seguro de que desea eliminar la huella digital registrada?')) {
                this.huellaTemplate = '';
                this.huellaRegistrada = false;
                this.mensaje = '';
                this.tipoMensaje = 'info';

                // Disparar evento para que Filament detecte el cambio
                this.$dispatch('input', '');
            }
        }
    }
}
</script>
@endpush
