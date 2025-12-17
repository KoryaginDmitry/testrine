<?php

use DkDev\Testrine\Collectors\AuthCollector;
use DkDev\Testrine\Collectors\CodeCollector;
use DkDev\Testrine\Collectors\ContentTypeCollector;
use DkDev\Testrine\Collectors\DescriptionCollector;
use DkDev\Testrine\Collectors\GroupCollector;
use DkDev\Testrine\Collectors\MethodCollector;
use DkDev\Testrine\Collectors\PathCollector;
use DkDev\Testrine\Collectors\RequestCollector;
use DkDev\Testrine\Collectors\ResponseCollector;
use DkDev\Testrine\Collectors\SummaryCollector;
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
use DkDev\Testrine\Mappers\AuthMapper;
use DkDev\Testrine\Mappers\DescriptionMapper;
use DkDev\Testrine\Mappers\GroupMapper;
use DkDev\Testrine\Mappers\MethodMapper;
use DkDev\Testrine\Mappers\PathMapper;
use DkDev\Testrine\Mappers\RequestMapper;
use DkDev\Testrine\Mappers\ResponseMapper;
use DkDev\Testrine\Mappers\SummaryMapper;
use DkDev\Testrine\Resolvers\Code\InvalidDataCodeResolver;
use DkDev\Testrine\Resolvers\Code\InvalidRouteParamsResolver;
use DkDev\Testrine\Resolvers\Code\ValidDataCodeResolver;
use DkDev\Testrine\Resolvers\Contract\CodeContractResolver;
use DkDev\Testrine\Resolvers\Contract\DocIgnoreResolver;
use DkDev\Testrine\Resolvers\Contract\FakeStorageResolver;
use DkDev\Testrine\Resolvers\Contract\InvalidateContractResolver;
use DkDev\Testrine\Resolvers\Contract\InvalidParametersCodeResolver;
use DkDev\Testrine\Resolvers\Contract\InvalidParametersContractResolver;
use DkDev\Testrine\Resolvers\Contract\JobResolver;
use DkDev\Testrine\Resolvers\Contract\MockResolver;
use DkDev\Testrine\Resolvers\Contract\NotificationResolver;
use DkDev\Testrine\Resolvers\Contract\ParametersContractResolver;
use DkDev\Testrine\Resolvers\Contract\ResponseContractResolver;
use DkDev\Testrine\Resolvers\Contract\SeedResolver;
use DkDev\Testrine\Resolvers\Contract\ValidateContractResolver;
use DkDev\Testrine\Strategies\Auth\SanctumAuthStrategy;
use DkDev\Testrine\Strategies\Auth\WithoutAuthStrategy;

return [
    'groups' => [
        'default' => [

            'users' => [
                'guest',
                'user',
            ],

            'document' => true,

            'contracts' => [
                CodeContract::class => CodeContractResolver::class,
                DocIgnoreContract::class => DocIgnoreResolver::class,
                FakeStorageContract::class => FakeStorageResolver::class,
                InvalidateCodeContract::class => InvalidateContractResolver::class,
                InvalidateContract::class => InvalidateContractResolver::class,
                InvalidParametersCodeContract::class => InvalidParametersCodeResolver::class,
                InvalidParametersContract::class => InvalidParametersContractResolver::class,
                JobContract::class => JobResolver::class,
                MockContract::class => MockResolver::class,
                NotificationContract::class => NotificationResolver::class,
                ParametersContract::class => ParametersContractResolver::class,
                SeedContract::class => SeedResolver::class,
                ValidateContract::class => ValidateContractResolver::class,
                ResponseContract::class => ResponseContractResolver::class,
            ],

            'code' => [
                'valid_data' => ValidDataCodeResolver::class,
                'invalid_data' => InvalidDataCodeResolver::class,
                'invalid_route_params' => InvalidRouteParamsResolver::class,
            ],

            'auth' => [
                'guest' => WithoutAuthStrategy::class,
                'user' => SanctumAuthStrategy::class,
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

        'collectors' => [
            GroupCollector::class,
            CodeCollector::class,
            MethodCollector::class,
            PathCollector::class,
            ContentTypeCollector::class,
            AuthCollector::class,
            SummaryCollector::class,
            DescriptionCollector::class,
            RequestCollector::class,
            ResponseCollector::class,
        ],

        'mappers' => [
            PathMapper::class,
            MethodMapper::class,
            GroupMapper::class,
            AuthMapper::class,
            SummaryMapper::class,
            DescriptionMapper::class,
            ResponseMapper::class,
            RequestMapper::class,
        ],
    ],
];
