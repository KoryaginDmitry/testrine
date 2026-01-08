# Testrine

The package covers the application with tests (analyzing routes, Eloquent resources, FormRequests, and Attributes). 
Based on the test results, information is collected for each route, and then OpenAPI documentation is generated from the collected data.
The package is intended for Laravel developers.

## Installation

```bash
composer require dk-dev/testrine
```

Publishing config, translations, and resources

```bash
php artisan vendor:publish --provider="DkDev\Testrine\TestrineServiceProvider"
```

General workflow:
- Define the configuration,
- Create base classes for each group,
- Cover it with tests,
- Run the tests,
- Collectors collect data,
- Processors generate documentation,
- Save the documentation.

## Configuration

### Key Points

- You can have different groups (e.g., web, api, admin), each group can have its own users, response codes, etc.
- A default group is already defined in the configuration. Its settings apply to all other groups, but this group is not 
- used in test generation,
- In the original documentation, the "api" group was added, all its settings will be taken from the default group, but we 
- can override them.

### Analysis of each configuration block

#### tests block

```php
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
        
        'auth_middleware' => 'auth:sanctum',
        
        'auth' => [
            'guest' => WithoutAuthStrategy::class,
            'user' => SanctumAuthStrategy::class,
        ],
    ],

    'api' => [],
],
```

#### users

In users, we define which users will be used within the group. For example, in api, there might only be guest and user.
For example, in the web group, there might be performer, customer, and guest. There might also be other groups with their own users. 

```php
'users' => [
    'guest',
    'user',
],
```

**Important!** For each user, you will need to implement methods in the TestCase class or in base classes that will be created later. 
Below is an example implementation for the initial configuration.

```php
<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function getUser(): User
    {
        return User::query()->first();
    }

    public function getGuest()
    {
        return null;
    }
}
```

#### document

This parameter is needed if we need to enable/disable data collection by group.

```php
'document' => true,
```

#### contracts

**Important!** Contracts define which contracts will be used in the group and which resolvers will determine whether a 
contract is needed for each current route. This block is used when calling a console command that covers routes with tests. 
The contract obligates the test to implement certain logic, such as checking for the transfer of valid data, parameters, etc. 
A detailed description of the contracts follows.

```php
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
```

#### auth_middleware

Determines which middleware is responsible for authorization in the group.

```php
'auth_middleware' => 'auth:sanctum',
```

#### code

The code block specifies which resolvers will be used to determine the response code in the test.

```php
'code' => [
    'valid_data' => ValidDataCodeResolver::class,
    'invalid_data' => InvalidDataCodeResolver::class,
    'invalid_route_params' => InvalidRouteParamsResolver::class,
],
```

#### auth

An authorization strategy must be defined for each user. Initially, there are four:
- PassportAuthStrategy,
- SanctumAuthStrategy,
- WebAuthStrategy,
- WithoutAuthStrategy.

You can add your own strategies.

```php
'auth' => [
    'guest' => WithoutAuthStrategy::class,
    'user' => SanctumAuthStrategy::class,
],
```

#### documentation block

```php
    'docs' => [

        'renderer' => Renderer::SWAGGER,

        'routes' => [

            'middlewares' => [],

            'ui' => [
                'name' => 'docs.ui',
                'path' => 'api/documentation',
                'middlewares' => [],
            ],

            'scheme' => [
                'name' => 'docs.scheme',
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

        'dto' => OpenApi::class,

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
```

#### renderer

Specify which renderer will be used to display the documentation. Currently, only Swagger is available.

```php
'renderer' => Renderer::SWAGGER,
```

#### routes

We define route data for the UI schema and its source data. You can define middleware for both routes or each route separately,
as well as route names and paths.

```php
'routes' => [

    'middlewares' => [],

    'ui' => [
        'name' => 'docs.ui',
        'path' => 'api/documentation',
        'middlewares' => [],
    ],

    'scheme' => [
        'name' => 'docs.scheme',
        'path' => 'api/documentation/scheme',
        'middlewares' => [],
    ],
],
```

#### openapi, info and servers

You can determine the OpenApi version, data from the main information and server.

```php
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
```

#### auth

There is already a list of ready-made authorization schemes (security_schemes), you need to select the required one (in security_scheme)
or add new ones if necessary

```php
'auth' => [
            
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
```

#### storage

We determine the driver, the storage location for test data, and the location and name of the documentation file.

```php
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
```

#### collectors

A collector is a class that collects test data and writes the result to an array under a specific key.

```php
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
```

#### dto

We define a class that will be filled with data and from which documentation will be generated.

```php
'dto' => OpenApi::class,
```

#### processors

The processor analyzes the data collected by the collectors and adds it to the documentation class. The order of the 
processors is very important.

```php
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
```

### Commands

1. After defining the configuration, you need to create base classes by group. Each group will have its own subdirectory 
   and base class for tests in the test directory.

    ```bash
    php artisan testrine:init
    ```

2. Application test coverage.

    ```bash
    php artisan testrine:tests
    ```

   The command covers routes with tests. If you need to overwrite existing tests, you can use the -R flag.

3. Creating one test file

    ```bash
    php artisan testrine:make
    ```

4. Running tests

    ```bash
    php artisan test
    ```

5. Analysis of collected data

    ```bash
    php artisan testrine:parse
    ```

6. Deleting collected data

    ```bash
    php artisan testrine:destroy
    ```

7. A command that combines running tests, analyzing collected data, and deleting collected data

    ```bash
    php artisan testrine:generate
    ```

### Default values for route parameters, valid data, and response codes

There may be situations where we need to:
- specify the value of route parameters,
- data in the request body,
- a default response code.
To do this, we need to use the DkDev\Testrine\Testrine and DkDev\Testrine\CodeBuilder\Builder classes.

1. Route parameters
    In the parameters, I'll pass:
   - routeName - the name of a specific route or null for all routes,
   - key - the parameter key,
   - value - the value. You can use DkDev\Testrine\CodeBuilder\Builder or simply pass a string
    
       ```php
       Testrine::routeParams()->pushValid(
           routeName: 'api.verification.verify',
           key: 'id',
           value: Builder::make()->method('getUser')->property('id'),
       );
   
      Testrine::routeParams()->pushInalid(
           routeName: 'api.verification.verify',
           key: 'hash',
           value: Builder::make(root: 'str()')->method('random', 5),
       );
       ```

2. Request body data.

   To define default data in the request body, you need to add the default parameter value for a specific route or for all 
   routes to the rules using the * sign.

    ```php
    Testrine::rules()->setDefaultValue(
        routeName: 'api.auth.login',
        key: 'email',
        value: Builder::make()->method('getUser')->property('email'),
    );
    ```

3. Default response code.
   - Define the resolver,
   - Route name,
   - Specify the code.

       ```php
       Testrine::code()->setDefaultCode(
           resolver: ValidDataCodeResolver::class,
           routeName: 'api.auth.logout',
           value: 204
       );
       ```

### Attributes

Attributes allow you to add data to your documentation.

Attributes can be added:
- To FormRequest,
- To Eloquent Resource,
- Above the controller class,
- Above the controller method.

Priority:
1. Method
2. Controller class
3. FormRequest
4. Eloquent Resource.

#### Group

Adds a route to a group.

```php
use DkDev\Testrine\Attributes\Group;

#[Group(name: 'GroupName')]
```

#### Code

Description of response codes.

```php
use DkDev\Testrine\Attributes\Code;

#[Code(code: 201, description: 'Post created')]
```

#### Description

Description of the route.

```php
use DkDev\Testrine\Attributes\Description;

#[Description(description: 'Post creat endpoint')]
```

#### Summary

Brief description of the route.

```php
use DkDev\Testrine\Attributes\Summary;

#[Summary(summary: 'Post creat endpoint')]
```

#### Resource

Specifies the Eloquent Resource that is used to respond to a route, and also specifies a nested resource within other resources.

```php
use DkDev\Testrine\Attributes\Resource;

#[Resource(name: UserResource::class)]
#[Resource(name: UserResource::class, key: 'users')]
```

#### Property

Describes the parameters/properties of the response/request.

```php
use DkDev\Testrine\Attributes\Property;
use \DkDev\Testrine\Enums\Attributes\Type;
use \DkDev\Testrine\Enums\Attributes\StringFormat;
use \DkDev\Testrine\Enums\Attributes\In;

#[Property(
    name: 'email',
    type: Type::STRING,
    format: StringFormat::EMAIL,
    in: In::BODY,
    example: 'example@example.com',
    description: 'user email address',
    enum: null,
    required: true,
)]

#[Property(
    name: 'gender',
    type: Type::ENUM,
    format: null,
    in: In::BODY,
    example: Gender::WOMAN->value,
    description: 'user gender',
    enum: Gender::class,
    required: true,
)]
```

### Contracts

1. AssertContract. 

    This is used when additional checks are required. An `assert` method must be implemented.
    The method accepts the current test and the username under which the test is being executed.
    
    ```php
    public function assert(TestResponse $test, string $userKey): void
    {
        // todo
    }
    ```

2. CodeContract. 

   Used when you need to override the default success response codes. You must implement the `codes` method, which returns 
   an associative array, where the key is the user and the value is the code.
    
    ```php
     public function codes(): array
    {
        return [
            'guest' => 200,
            'user' => 200,
        ];
    }
    ```

3. DocIgnoreContract. 

    Used when this test should be ignored in the documentation. This contract's resolver has the `HasContractRoutes` trait, 
    meaning routes can be specified for the resolver to automatically use this contract.
    
    ```php
    Testrine::contracts()->setContractRoutes(
        contract: DocIgnoreContract::class,
        routes: [
            'api.home.index',
        ]
    );
    ```

4. FakeStorageContract. 

    Used when you need to call `Storage::fake()` before a test. This contract's resolver has the `HasContractRoutes` trait.

5. InvalidateCodeContract. 

   This is used when a different code than the default is needed for invalid data. The `invalidDataCode` method must be implemented.

    ```php
    public function invalidDataCode(): int
    {
        return 301;
    }
    ```

6. InvalidateContract. 

   The contract is used when checking for invalid data transfer. The 'invalidData' method must be implemented.
    
    ```php
    public function invalidData(): array
    {
        return [
            'name' => 123,
            'age' => 'fake'
        ]
    }
    ```

7. InvalidParametersCodeContract. 

   Used when you need to override default codes for invalid route parameters. You must implement the `codesForInvalidParameters` method.
    
   ```php
    public function codesForInvalidParameters(): array
    {
        return [
            'guest' => 403,
            'user' => 404,   
        ];
    }
    ```
   
8. InvalidParametersContract. 

   This is used when you need to check for invalid route parameters. You must implement the 'invalidParameters' method.

    ```php
    public function invalidParameters(): array
    {
        return [
            'post' => 'sadas'  
        ];
    }
    ```

9. JobContract. 

   This is used when you need to check whether a job has been called. `Queue::fake()` will already be called. 
   This contract's resolver has the `HasContractRoutes` trait. You must implement the `jobs` method to check whether 
   the job has been called.

    ```php
    public function jobs(): void
    {
        
    }
    ```

10. MockContract. 

    This is used when mocking classes. The resolver for this contract has the `HasContractRoutes` trait.
    You must implement the `mockAction` method, where all mocks will be performed.
    
    ```php
    public function mockAction(): void
    {
    
    }
    ```

11. NotificationContract. 

    Used when checking notification calls. This contract's resolver has the `HasContractRoutes` trait.
    The `notifications` method must be implemented.

    ```php
    public function notifications(): void
    {
    
    }
    ```

12. ParametersContract.

    If you need to check whether valid route parameters are passed, you need to implement the `parameters` method.

    ```php
    public function parameters(): array
    {
        return [
            'post' => 1
        ];
    }
    ```

13. ResponseContract.

    If you need to check the response structure, you must implement the `getResponseStructure` method.
    
    ```php
    public function getResponseStructure(): array
    {
        return [
            'data' => [
                'id',
                'name',
            ]
        ];
    }
    ```

14. SeedContract. 

    If you need to call seeders before a test, this contract's resolver has the `HasContractRoutes` trait. You need to implement the `dbSeed` method.

    ```php
    public function dbSeed(): void
    {
    
    }
    ```

15. ValidateContract. 

    If you need to check whether the data you're passing is valid, you need to implement the `validData` method.

    ```php
    public function validData(): array
    {
        return [
            'name' => 'fake_name',
            'age' => 21
        ];
    }
    ```

### RequestPayload rules

A generator based on validation rules is used to generate valid data. Each rule has its own handler.
Rules can be extended. To do this, create a class inheriting from DkDev\Testrine\RequestPayload\Rules\BaseRule and implement
its abstract methods getPriority, hasThisRule, and getValue. An example implementation of the 'email' rule.

```php
<?php

declare(strict_types=1);

namespace DkDev\Testrine\RequestPayload\Rules;

use DkDev\Testrine\Enums\RequestPayload\RulePriority;
use DkDev\Testrine\CodeBuilder\Builder;

class EmailRule extends BaseRule
{
    public function getPriority(): RulePriority
    {
        return RulePriority::MEDIUM;
    }

    public function hasThisRule(): bool
    {
        return in_array('email', $this->rules, true);
    }

    public function getValue(): string
    {
        return Builder::make('fake()')->method('email')->build();
    }
}
```

Then you need to register a new rule.

```php
Testrine::rules()->add(NewRule::class);
```

You can also completely redefine the rules, clear them, and get a list of rules.

```php
Testrine::rules()->set([
    RequiredRule::class,
    EmailRule::class,
]);

Testrine::rules()->clear();

$rules = Testrine::rules()->list();
```

### Customization


You can also customize auth strategies, resolver contracts, collectors, processors, code resolvers, and ClassNameBuilder, 
which automatically generates the class name. To do this, we create a callback with our own handler. The callback always 
receives the current class, for which we override the logic.

```php
Testrine::handlers()->setHandler(ClassNameBuilder::class, function (ClassNameBuilder $builder) {
    // todo 
});
```

### Generation events

You can set handlers for various events.

```php
Testrine::handlers()->afterDestroy(function () {
    // todo   
});

Testrine::handlers()->beforeDestroy(function () {
    // todo   
});

Testrine::handlers()->afterGeneration(function () {
    // todo   
});

Testrine::handlers()->beforeGeneration(function () {
    // todo   
});

// will only work if tests are called via testrine:generate
Testrine::handlers()->afterTests(function () {
    // todo   
});

// will only work if tests are called via testrine:generate
Testrine::handlers()->beforeTests(function () {
    // todo   
});
```

### CodeBuilder

Through it, we can:
- access the current test
- call a property
- call a property with a null-safe operator
- call a method
- call a method with a null-safe operator
- call a function
- call a static function of a class
- simply return a string

```php
use DkDev\Testrine\CodeBuilder\Builder;

// the builder will start with $this
Builder::make(); 

// We call the getUser method and get the email property. The code will be as follows: $this->getUser()->email;
Builder::make()->method('getUser')->property('email'); 

// the same, but with the null-safe operator $this?->getUser()?->email;
Builder::make()->safeMethod('getUser')->safeProperty('email');

// Calling the user's email encryption function. Result: sha1($this->getUser()->email);
Builder::make('')->func('sha1', Builder::make()->method('getUser')->property('email')), 

// return string. Result is 'password'
Builder::make('')->raw('password')
```
