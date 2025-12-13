<?php

return [
    'init' => [
        'success' => 'Initialization was successful',
        'fail' => 'An initialization error occurred',
        'info' => 'Created group :group, base class path :class',
    ],

    'make' => [
        'write_class_name' => 'Enter class name',
        'write_route_name' => 'Enter route name',
        'write_middlewares' => 'Enter the middleware separated by commas (there must be a comma and a space between the middleware)',
        'select_contracts' => 'Select the interfaces that the test will need to implement',
        'success' => 'Class :path successfully created',
        'route_not_found' => 'Route with name :name not found',
    ],

    'test' => [
        'skipped' => [
            'invalid_data' => 'The test was skipped because the called class does not implement the invalid data passing interface.',
            'invalid_parameters' => 'The test was skipped because the called class does not implement the invalid parameter passing interface.',
        ],
    ],
];
