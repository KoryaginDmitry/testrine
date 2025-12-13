<?php

use DkDev\Testrine\Contracts\CodeContract;
use DkDev\Testrine\Contracts\DocIgnoreContract;
use DkDev\Testrine\Contracts\FakeStorageContract;
use DkDev\Testrine\Contracts\InvalidateCodeContract;
use DkDev\Testrine\Contracts\InvalidateContract;
use DkDev\Testrine\Contracts\InvalidParametersCodeContract;
use DkDev\Testrine\Contracts\InvalidParametersContract;
use DkDev\Testrine\Contracts\JobContract;
use DkDev\Testrine\Contracts\MockContract;
use DkDev\Testrine\Contracts\NotificationContract;
use DkDev\Testrine\Contracts\ParametersContract;
use DkDev\Testrine\Contracts\ResponseContract;
use DkDev\Testrine\Contracts\SeedContract;
use DkDev\Testrine\Contracts\ValidateContract;
use DkDev\Testrine\Strategies\Auth\SanctumAuthStrategy;
use DkDev\Testrine\Strategies\Auth\WithoutAuthStrategy;
use DkDev\Testrine\Strategies\Code\InvalidDataCodeStrategy;
use DkDev\Testrine\Strategies\Code\InvalidRouteParamsStrategy;
use DkDev\Testrine\Strategies\Code\ValidDataCodeStrategy;
use DkDev\Testrine\Strategies\Contract\CodeContractStrategy;
use DkDev\Testrine\Strategies\Contract\DocIgnoreStrategy;
use DkDev\Testrine\Strategies\Contract\FakeStorageStrategy;
use DkDev\Testrine\Strategies\Contract\InvalidateContractStrategy;
use DkDev\Testrine\Strategies\Contract\InvalidParametersCodeStrategy;
use DkDev\Testrine\Strategies\Contract\InvalidParametersContractStrategy;
use DkDev\Testrine\Strategies\Contract\JobStrategy;
use DkDev\Testrine\Strategies\Contract\MockStrategy;
use DkDev\Testrine\Strategies\Contract\NotificationStrategy;
use DkDev\Testrine\Strategies\Contract\ParametersContractStrategy;
use DkDev\Testrine\Strategies\Contract\ResponseContractStrategy;
use DkDev\Testrine\Strategies\Contract\SeedStrategy;
use DkDev\Testrine\Strategies\Contract\ValidateContractStrategy;
use DkDev\Testrine\Strategies\Generators\AuthGeneratorStrategy;
use DkDev\Testrine\Strategies\Generators\DescriptionGeneratorStrategy;
use DkDev\Testrine\Strategies\Generators\GroupGeneratorStrategy;
use DkDev\Testrine\Strategies\Generators\MethodGeneratorStrategy;
use DkDev\Testrine\Strategies\Generators\PathGeneratorStrategy;
use DkDev\Testrine\Strategies\Generators\RequestGeneratorStrategy;
use DkDev\Testrine\Strategies\Generators\ResponseGeneratorStrategy;
use DkDev\Testrine\Strategies\Generators\SummaryGeneratorStrategy;
use DkDev\Testrine\Strategies\Parser\AuthStrategy;
use DkDev\Testrine\Strategies\Parser\CodeStrategy;
use DkDev\Testrine\Strategies\Parser\ContentTypeParser;
use DkDev\Testrine\Strategies\Parser\DescriptionStrategy;
use DkDev\Testrine\Strategies\Parser\GroupStrategy;
use DkDev\Testrine\Strategies\Parser\MethodStrategy;
use DkDev\Testrine\Strategies\Parser\PathStrategy;
use DkDev\Testrine\Strategies\Parser\RequestStrategy;
use DkDev\Testrine\Strategies\Parser\ResponseStrategy;
use DkDev\Testrine\Strategies\Parser\SummaryStrategy;

return [
    'groups' => [
        'default' => [

            'users' => [
                'guest',
                'user',
            ],

            'document' => true,

            'strategies' => [
                'contracts' => [
                    CodeContract::class => CodeContractStrategy::class,
                    DocIgnoreContract::class => DocIgnoreStrategy::class,
                    FakeStorageContract::class => FakeStorageStrategy::class,
                    InvalidateCodeContract::class => InvalidateContractStrategy::class,
                    InvalidateContract::class => InvalidateContractStrategy::class,
                    InvalidParametersCodeContract::class => InvalidParametersCodeStrategy::class,
                    InvalidParametersContract::class => InvalidParametersContractStrategy::class,
                    JobContract::class => JobStrategy::class,
                    MockContract::class => MockStrategy::class,
                    NotificationContract::class => NotificationStrategy::class,
                    ParametersContract::class => ParametersContractStrategy::class,
                    SeedContract::class => SeedStrategy::class,
                    ValidateContract::class => ValidateContractStrategy::class,
                    ResponseContract::class => ResponseContractStrategy::class,
                ],

                'code' => [
                    'valid_data' => ValidDataCodeStrategy::class,
                    'invalid_data' => InvalidDataCodeStrategy::class,
                    'invalid_route_params' => InvalidRouteParamsStrategy::class,
                ],

                'auth' => [
                    'guest' => WithoutAuthStrategy::class,
                    'user' => SanctumAuthStrategy::class,
                ],
            ],
        ],

        'api' => [],
    ],

    'swagger' => [
        'routes' => [
            'middlewares' => [],

            'ui' => [
                'name' => 'swagger.ui',
                'path' => 'api/documentation',
                'middlewares' => [],
            ],

            'scheme' => [
                'name' => 'swagger.scheme',
                'path' => 'api/documentation/scheme',
                'middlewares' => [],
            ],
        ],

        'openapi' => '3.0.0',

        'info' => [
            'title' => 'API documentation',
            'description' => 'API documentation',
            'version' => '1.0.0',
            'termsOfService' => 'https://example.com/terms',
            'contact' => [
                'name' => 'example',
                'url' => 'https://example.com',
                'email' => 'example@mail.ru',
            ],
            'license' => [
                'name' => 'CC Attribution-ShareAlike 4.0 (CC BY-SA 4.0)',
                'url' => 'https://openweathermap.org/price',
            ],
        ],

        'servers' => [
            [
                'url' => env('APP_URL'),
                'description' => 'Server for testing',
            ],
        ],

        'auth' => [
            'middleware' => 'auth:sanctum',

            'security_scheme' => 'sanctum',

            'security_schemes' => [

                'passport' => [
                    'type' => 'http',
                    'scheme' => 'bearer',
                    'bearerFormat' => 'JWT',
                    'in' => 'header',
                    'name' => 'Authorization',
                    'description' => 'Use the Bearer token issued by Passport.',
                ],

                'sanctum' => [
                    'type' => 'http',
                    'scheme' => 'bearer',
                    'bearerFormat' => 'Token',
                    'in' => 'header',
                    'name' => 'Authorization',
                    'description' => 'Use Sanctum personal access token.',
                ],

                'api_key_header' => [
                    'type' => 'apiKey',
                    'in' => 'header',
                    'name' => 'X-API-Key',
                    'description' => 'Custom API key via header.',
                ],

                'jwt' => [
                    'type' => 'http',
                    'scheme' => 'bearer',
                    'bearerFormat' => 'JWT',
                    'description' => 'JWT authentication.',
                ],
            ],
        ],

        'storage' => [
            'driver' => 'local',
            'data' => [
                'path' => 'swagger/data/',
            ],
            'docs' => [
                'name' => 'api-docs',
                'path' => 'swagger/api-docs/',
            ],
        ],

        'strategies' => [
            'parsers' => [
                GroupStrategy::class,
                CodeStrategy::class,
                MethodStrategy::class,
                PathStrategy::class,
                ContentTypeParser::class,
                AuthStrategy::class,
                SummaryStrategy::class,
                DescriptionStrategy::class,
                RequestStrategy::class,
                ResponseStrategy::class,
            ],

            'generators' => [
                PathGeneratorStrategy::class,
                MethodGeneratorStrategy::class,
                GroupGeneratorStrategy::class,
                AuthGeneratorStrategy::class,
                SummaryGeneratorStrategy::class,
                DescriptionGeneratorStrategy::class,
                ResponseGeneratorStrategy::class,
                RequestGeneratorStrategy::class,
            ],
        ],
    ],
];
