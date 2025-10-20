<div class="huella-modal-content">
    <!-- Instrucciones -->
    <div class="mb-6 text-center">
        <h3 class="text-lg font-medium text-gray-900 mb-2">Instrucciones</h3>
        <p class="text-gray-600">Ponga su dedo sobre el lector</p>
    </div>

    <!-- Campos de entrada -->
    <div class="grid grid-cols-2 gap-4 mb-6">
        <div>
            <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
            <input type="text" id="nombre" name="nombre" value="{{ $nombre ?? '' }}" class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 text-gray-600 cursor-not-allowed" readonly required>
        </div>
        <div>
            <label for="documentoRegistro" class="block text-sm font-medium text-gray-700 mb-1">Documento</label>
            <input type="text" id="documentoRegistro" name="documentoRegistro" value="{{ $documento ?? '' }}" class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 text-gray-600 cursor-not-allowed" readonly required>
        </div>
    </div>

    <!-- Botones de acción -->
    <div class="flex flex-col items-center gap-4 mb-6">
        <button id="btnRegistrar" type="button" class="w-full max-w-xs px-6 py-3 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 font-medium">
            Registrar Huella
        </button>
        <button id="btnVerificar" type="button" onclick="testClick()" class="w-full max-w-xs px-6 py-3 bg-primary-600 text-white rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 font-medium">
            Capturar Huella
        </button>
    </div>

    <!-- Campo para documento de verificación (oculto) -->
    <div class="mb-6 hidden">
        <label for="documentoVerificacion" class="block text-sm font-medium text-gray-700 mb-1">Documento para Verificación</label>
        <input type="text" id="documentoVerificacion" name="documentoVerificacion" value="{{ $documento ?? '' }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ingrese documento para verificar">
    </div>

    <!-- Área de mensajes de estado -->
    <div class="text-center mb-6">
        <div id="statusMessages" class="status p-3 rounded-md"></div>
    </div>

    <!-- Botón de cerrar -->
    <div class="flex justify-end">
        <button type="button" onclick="window.close()" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">
            Cerrar
        </button>
    </div>

    <!-- Estilos CSS para los mensajes de estado -->
    <style>
        .status {
            font-weight: 500;
            border-radius: 0.375rem;
            padding: 0.75rem;
        }
        .status-success {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }
        .status-error {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }
    </style>

    <!-- Test básico del modal -->
    <script>
        console.log('=== MODAL CARGADO ===');
        alert('Modal cargado correctamente');
        
        // Test del botón con onclick directo
        function testClick() {
            alert('¡Botón funcionando!');
            console.log('Botón clickeado');
        }
        
        // Hacer la función global
        window.testClick = testClick;
        
        console.log('Función testClick definida');
    </script>

</div>
