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
        'write_success' => 'Class :path successfully created',
        'rewrite_success' => 'Class :path successfully overwritten',
        'route_not_found' => 'Route with name :name not found',
        'test_already_exists' => 'The ":path" test is ready. Should I rewrite it?',
        'skipped' => 'Test ":path" skipped',
    ],

    'test' => [
        'skipped' => [
            'invalid_data' => 'The test was skipped because the called class does not implement the invalid data passing interface.',
            'invalid_parameters' => 'The test was skipped because the called class does not implement the invalid parameter passing interface.',
        ],

        'errors' => [
            'route' => [
                'not_found' => 'Route with name :route_name not found!',
                'not_contain_middlewares' => 'The route does not contain middleware :name',
                'different_amount_middlewares' => 'The route contains a different amount of middleware.',
            ],

            'resource' => [
                'parse' => 'Error retrieving resource structure :resource. Error: ":error"',
            ],
        ],
    ],
];
