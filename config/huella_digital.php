<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Configuración del Servicio de Huella Digital
    |--------------------------------------------------------------------------
    |
    | Configuración para el servicio de huella digital SecuGen
    |
    */

    'secugen' => [
        // URL del servicio SecuGen
        'url' => env('SECUGEN_URL', 'https://localhost:8443'),

        // Licencia del SDK (vacía para modo de prueba)
        'licencia' => env('SECUGEN_LICENCIA', ''),

        // Configuración de captura
        'timeout' => env('SECUGEN_TIMEOUT', 10000),
        'calidad' => env('SECUGEN_CALIDAD', 50),
        'formato' => env('SECUGEN_FORMATO', 'ISO'),

        // Umbral de coincidencia
        'umbral_coincidencia' => env('SECUGEN_UMBRAL', 120),

        // Verificar certificados SSL (false para desarrollo)
        'verificar_ssl' => env('SECUGEN_VERIFICAR_SSL', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Modo de Desarrollo
    |--------------------------------------------------------------------------
    |
    | Si está habilitado, permite usar el modo de simulación cuando
    | no hay lector físico disponible
    |
    */
    'modo_desarrollo' => env('HUELLA_MODO_DESARROLLO', true),

    /*
    |--------------------------------------------------------------------------
    | Configuración de Base de Datos
    |--------------------------------------------------------------------------
    |
    | Configuración para el almacenamiento de plantillas
    |
    */
    'base_datos' => [
        'tabla' => 'beneficiarios',
        'campo' => 'huella_template',
    ],
];

