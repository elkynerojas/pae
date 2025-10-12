<?php

return [

    'actions' => [

        'disable_sorting' => [
            'label' => 'Deshabilitar ordenamiento',
        ],

        'enable_sorting' => [
            'label' => 'Habilitar ordenamiento',
        ],

        'filter' => [
            'label' => 'Filtrar',
            'modal' => [
                'heading' => 'Filtrar :label',
                'actions' => [
                    'apply' => [
                        'label' => 'Aplicar',
                    ],
                    'reset' => [
                        'label' => 'Restablecer',
                    ],
                ],
            ],
        ],

        'group' => [
            'label' => 'Agrupar',
        ],

        'open_bulk_actions' => [
            'label' => 'Abrir acciones',
        ],

        'toggle_columns' => [
            'label' => 'Alternar columnas',
        ],

    ],

    'columns' => [

        'text' => [

            'actions' => [
                'hide' => 'Ocultar',
                'show' => 'Mostrar',
                'sort_asc' => 'Ordenar ascendente',
                'sort_desc' => 'Ordenar descendente',
            ],

            'sorting' => [
                'asc' => 'Ordenar ascendente',
                'desc' => 'Ordenar descendente',
            ],

        ],

        'toggle' => [

            'actions' => [
                'hide' => 'Ocultar',
                'show' => 'Mostrar',
            ],

        ],

    ],

    'fields' => [

        'bulk_select_page' => [
            'label' => 'Seleccionar todos los elementos de esta página para acciones masivas.',
        ],

        'bulk_select_record' => [
            'label' => 'Seleccionar ":label" para acciones masivas.',
        ],

        'bulk_select_group' => [
            'label' => 'Seleccionar grupo ":label" para acciones masivas.',
        ],

        'search' => [
            'label' => 'Buscar',
            'placeholder' => 'Buscar...',
            'indicator' => 'Buscar',
        ],

        'search_indicator' => [
            'label' => 'Buscar',
        ],

    ],

    'summary' => [
        'heading' => 'Resumen',
    ],

    'actions' => [

        'disable_sorting' => [
            'label' => 'Deshabilitar ordenamiento',
        ],

        'enable_sorting' => [
            'label' => 'Habilitar ordenamiento',
        ],

        'filter' => [
            'label' => 'Filtrar',
            'modal' => [
                'heading' => 'Filtrar :label',
                'actions' => [
                    'apply' => [
                        'label' => 'Aplicar',
                    ],
                    'reset' => [
                        'label' => 'Restablecer',
                    ],
                ],
            ],
        ],

        'group' => [
            'label' => 'Agrupar',
        ],

        'open_bulk_actions' => [
            'label' => 'Abrir acciones',
        ],

        'toggle_columns' => [
            'label' => 'Alternar columnas',
        ],

    ],

    'empty' => [

        'heading' => 'Sin registros',

        'description' => 'Crea un :model para comenzar.',

    ],

    'filters' => [

        'actions' => [

            'apply' => [
                'label' => 'Aplicar filtros',
            ],

            'remove' => [
                'label' => 'Quitar filtro',
            ],

            'remove_all' => [
                'label' => 'Quitar todos los filtros',
            ],

            'reset' => [
                'label' => 'Restablecer',
            ],

        ],

        'heading' => 'Filtros',

        'indicator' => 'Filtros activos',

        'multi_select' => [
            'placeholder' => 'Todos',
        ],

        'select' => [
            'placeholder' => 'Todos',
        ],

        'trashed' => [

            'label' => 'Registros eliminados',

            'only_trashed' => 'Solo registros eliminados',

            'with_trashed' => 'Con registros eliminados',

            'without_trashed' => 'Sin registros eliminados',

        ],

    ],

    'grouping' => [

        'fields' => [

            'group' => [
                'label' => 'Agrupar por',
                'placeholder' => 'Agrupar por...',
            ],

            'direction' => [

                'label' => 'Dirección del grupo',

                'options' => [
                    'asc' => 'Ascendente',
                    'desc' => 'Descendente',
                ],

            ],

        ],

    ],

    'header_actions' => [

        'label' => 'Acciones',

        'modal' => [

            'actions' => [

                'replicate' => [
                    'label' => 'Replicar',
                ],

            ],

            'heading' => 'Replicar :label',

            'subheading' => '¿Estás seguro de que quieres replicar este registro?',

        ],

    ],

    'reorder' => [

        'label' => 'Reordenar registros',

    ],

    'reorder_indicator' => 'Arrastra y suelta los registros en el orden deseado.',

    'search' => [

        'label' => 'Buscar',
        'placeholder' => 'Buscar...',
        'indicator' => 'Buscar',

    ],

    'selection_indicator' => [

        'selected_count' => '1 registro seleccionado.|:count registros seleccionados.',

        'actions' => [

            'select_all' => [
                'label' => 'Seleccionar todos los :count',
            ],

            'deselect_all' => [
                'label' => 'Deseleccionar todos',
            ],

        ],

    ],

    'sorting' => [

        'fields' => [

            'column' => [
                'label' => 'Ordenar por',
            ],

            'direction' => [

                'label' => 'Dirección de ordenamiento',

                'options' => [
                    'asc' => 'Ascendente',
                    'desc' => 'Descendente',
                ],

            ],

        ],

    ],

];
