<?php

use Dkdev\Testrine\Collectors\AuthCollector;
use Dkdev\Testrine\Collectors\CodeCollector;
use Dkdev\Testrine\Collectors\ContentTypeCollector;
use Dkdev\Testrine\Collectors\DescriptionCollector;
use Dkdev\Testrine\Collectors\GroupCollector;
use Dkdev\Testrine\Collectors\MethodCollector;
use Dkdev\Testrine\Collectors\PathCollector;
use Dkdev\Testrine\Collectors\RequestCollector;
use Dkdev\Testrine\Collectors\ResponseCollector;
use Dkdev\Testrine\Collectors\SummaryCollector;
use Dkdev\Testrine\Contracts\CodeContract;
use Dkdev\Testrine\Contracts\DocIgnoreContract;
use Dkdev\Testrine\Contracts\FakeStorageContract;
use Dkdev\Testrine\Contracts\InvalidateCodeContract;
use Dkdev\Testrine\Contracts\InvalidateContract;
use Dkdev\Testrine\Contracts\InvalidParametersCodeContract;
use Dkdev\Testrine\Contracts\InvalidParametersContract;
use Dkdev\Testrine\Contracts\JobContract;
use Dkdev\Testrine\Contracts\MockContract;
use Dkdev\Testrine\Contracts\NotificationContract;
use Dkdev\Testrine\Contracts\ParametersContract;
use Dkdev\Testrine\Contracts\ResponseContract;
use Dkdev\Testrine\Contracts\SeedContract;
use Dkdev\Testrine\Contracts\ValidateContract;
use Dkdev\Testrine\Mappers\AuthMapper;
use Dkdev\Testrine\Mappers\DescriptionMapper;
use Dkdev\Testrine\Mappers\GroupMapper;
use Dkdev\Testrine\Mappers\MethodMapper;
use Dkdev\Testrine\Mappers\PathMapper;
use Dkdev\Testrine\Mappers\RequestMapper;
use Dkdev\Testrine\Mappers\ResponseMapper;
use Dkdev\Testrine\Mappers\SummaryMapper;
use Dkdev\Testrine\Resolvers\Code\InvalidDataCodeResolver;
use Dkdev\Testrine\Resolvers\Code\InvalidRouteParamsResolver;
use Dkdev\Testrine\Resolvers\Code\ValidDataCodeResolver;
use Dkdev\Testrine\Resolvers\Contract\CodeContractResolver;
use Dkdev\Testrine\Resolvers\Contract\DocIgnoreResolver;
use Dkdev\Testrine\Resolvers\Contract\FakeStorageResolver;
use Dkdev\Testrine\Resolvers\Contract\InvalidateContractResolver;
use Dkdev\Testrine\Resolvers\Contract\InvalidParametersCodeResolver;
use Dkdev\Testrine\Resolvers\Contract\InvalidParametersContractResolver;
use Dkdev\Testrine\Resolvers\Contract\JobResolver;
use Dkdev\Testrine\Resolvers\Contract\MockResolver;
use Dkdev\Testrine\Resolvers\Contract\NotificationResolver;
use Dkdev\Testrine\Resolvers\Contract\ParametersContractResolver;
use Dkdev\Testrine\Resolvers\Contract\ResponseContractResolver;
use Dkdev\Testrine\Resolvers\Contract\SeedResolver;
use Dkdev\Testrine\Resolvers\Contract\ValidateContractResolver;
use Dkdev\Testrine\Strategies\Auth\SanctumAuthStrategy;
use Dkdev\Testrine\Strategies\Auth\WithoutAuthStrategy;

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
