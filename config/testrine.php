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
use DkDev\Testrine\Doc\OpenApi\OpenApi;
use DkDev\Testrine\Enums\Doc\Renderer;
use DkDev\Testrine\Processors\AuthProcessor;
use DkDev\Testrine\Processors\DescriptionProcessor;
use DkDev\Testrine\Processors\GroupProcessor;
use DkDev\Testrine\Processors\MethodProcessor;
use DkDev\Testrine\Processors\PathProcessor;
use DkDev\Testrine\Processors\RequestProcessor;
use DkDev\Testrine\Processors\ResponseProcessor;
use DkDev\Testrine\Processors\SummaryProcessor;
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

    /*
    |--------------------------------------------------------------------------
    | Test Groups Configuration
    |--------------------------------------------------------------------------
    |
    | Groups define testing and documentation contexts.
    | Each group may define users, authorization strategies,
    | contracts, response codes and documentation behavior.
    |
    */
    'groups' => [

        /*
        |----------------------------------------------------------------------
        | Default Group
        |----------------------------------------------------------------------
        |
        | The default group is used if no parameter is specified for a specific group.
        |
        */
        'default' => [

            /*
            | Define users within a group.
            */
            'users' => [
                'guest',
                'user',
            ],

            /*
            | Determine whether this group should be included
            | in documentation generation.
            */
            'document' => true,

            /*
            | Contracts and their corresponding resolvers.
            */
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

            /*
            | Default HTTP response code resolvers.
            */
            'code' => [
                'valid_data' => ValidDataCodeResolver::class,
                'invalid_data' => InvalidDataCodeResolver::class,
                'invalid_route_params' => InvalidRouteParamsResolver::class,
            ],

            /*
            | Middleware used to determine whether a route
            | requires authentication.
            */
            'auth_middleware' => 'auth:sanctum',

            /*
            | Authorization strategies per user.
            */
            'auth' => [
                'guest' => WithoutAuthStrategy::class,
                'user' => SanctumAuthStrategy::class,
            ],
        ],

        /*
        |----------------------------------------------------------------------
        | Custom Groups
        |----------------------------------------------------------------------
        |
        | Custom groups may override any configuration
        | from the default group.
        |
        */
        'api' => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Documentation Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for OpenAPI schema generation and
    | documentation UI rendering.
    |
    */
    'docs' => [

        /*
        | Documentation UI renderer
        */
        'renderer' => Renderer::SWAGGER,

        /*
        | Routes Configuration
        */
        'routes' => [

            /*
            | Global middlewares applied to all documentation routes.
            */
            'middlewares' => [],

            /*
            | Documentation UI route configuration.
            */
            'ui' => [
                'name' => 'docs.ui',
                'path' => 'api/documentation',
                'middlewares' => [],
            ],

            /*
            | OpenAPI schema route configuration.
            |
            | This route returns the raw OpenAPI JSON schema.
            */
            'scheme' => [
                'name' => 'docs.scheme',
                'path' => 'api/documentation/scheme',
                'middlewares' => [],
            ],
        ],

        /*
        | OpenAPI Specification Version
        */
        'openapi' => '3.0.0',

        /*
        | OpenAPI Info Block
        */
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

        /*
        | API Servers
        */
        'servers' => [
            [
                'url' => env('APP_URL'),
                'description' => 'Server for testing',
            ],
        ],

        /*
        | Authorization Configuration
        */
        'auth' => [

            /*
            | Default security scheme applied to protected endpoints.
            */
            'security_scheme' => 'sanctum',

            /*
            | Available OpenAPI security schemes.
            |
            | Custom schemes may be added here.
            */
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

        /*
        | Storage Configuration
        */
        'storage' => [
            'driver' => 'local',

            /*
            | Path for storing raw data collected from tests.
            */
            'data' => [
                'path' => 'swagger/data/',
            ],

            /*
            | Path for generated documentation files.
            */
            'docs' => [
                'name' => 'api-docs',
                'path' => 'docs/api-docs/',
            ],
        ],

        /*
        | Collectors gather data during test execution.
        */
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

        /*
        | The DTO class used as the root object for building
        | the OpenAPI documentation structure.
        */
        'dto' => OpenApi::class,

        /*
        | Processors transform collected data into
        | OpenAPI schema objects.
        */
        'processors' => [
            PathProcessor::class,
            MethodProcessor::class,
            GroupProcessor::class,
            AuthProcessor::class,
            SummaryProcessor::class,
            DescriptionProcessor::class,
            ResponseProcessor::class,
            RequestProcessor::class,
        ],
    ],
];
