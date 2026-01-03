<?php

return [
    'init' => [
        'success' => 'La inicialización se completó correctamente',
        'fail' => 'Ocurrió un error durante la inicialización',
        'info' => 'Grupo creado :group, ruta de la clase base: :class',
    ],

    'make' => [
        'write_class_name' => 'Introduce el nombre de la clase',
        'write_route_name' => 'Introduce el nombre de la ruta',
        'write_middlewares' => 'Introduce los middlewares separados por comas (con espacio)',
        'select_contracts' => 'Selecciona las interfaces que debe implementar la prueba',
        'write_success' => 'La clase :path se creó correctamente',
        'rewrite_success' => 'La clase :path se sobrescribió correctamente',
        'route_not_found' => 'No se encontró la ruta con el nombre :name',
        'test_already_exists' => 'La prueba ":path" ya existe. ¿Deseas sobrescribirla?',
        'skipped' => 'Prueba ":path" omitida',
    ],

    'test' => [
        'skipped' => [
            'invalid_data' => 'La prueba se omitió porque la clase llamada no implementa la interfaz de datos inválidos.',
            'invalid_parameters' => 'La prueba se omitió porque la clase llamada no implementa la interfaz de parámetros inválidos.',
        ],

        'errors' => [
            'route' => [
                'not_found' => '¡No se encontró la ruta con el nombre :route_name!',
                'not_contain_middlewares' => 'La ruta no contiene el middleware :name',
                'different_amount_middlewares' => 'La ruta contiene una cantidad diferente de middlewares.',
            ],

            'resource' => [
                'parse' => 'Error al obtener la estructura del recurso :resource. Error: ":error"',
            ],
        ],
    ],
];
