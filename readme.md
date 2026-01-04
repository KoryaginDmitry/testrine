# Testrine

Пакет покрывает приложение тестами, затем на основе тестов генерирует документацию к API

установка

```bash
composer required dk-dev/testrine
```

публикация данных

```bash
php artisan vendor:publish --provider="DkDev\Testrine\TestrineServiceProvider"
```

Общая схема работы.

Определяема конфигурацию -> создаем базовые классы для каждой группы -> покрываем тестами -> прогоняем тесты 
-> коллекторы собирают данные -> процессоры формируют документацию -> сохраняем документацию.

Далее все будет описано детальней.

настраиваем конфигурацию.

у нас могут быть различные группы (например web, api, admin), в каждой группе могут быть свои пользователи, 
свои коды ответа и т.д.

у нас уже определенна дефолтная группа. Ее настройки применяются ко всем другим группам, но в формировании тестов эта 
группа не участвует.

в исходной документации мы определяем группу api, все ее настройки получаем из группы default, но мы можем их переопределить.

теперь детальней разберем каждый блок в конфигурации групп.

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

в users мы определяем, какие пользователи будут использованы в рамках группы. Например, в api может быть только guest и user, 
к примеру в группе web могут быть performer, customer и guest. И могут быть другие группы со своими пользователями. 
```php
'users' => [
    'guest',
    'user',
],
```
Теперь важный момент! Для каждого пользователя нужно будет реализовать методы в классе TestCase или в базовых классах, которые мы создадим далее

Вот пример реализации для изначального конфига

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

Далее переходим к параметру document, этот параметр нужен если нам нужно включить/выключить сбор данных по группе.

```php
'document' => true,
```

Далее важный момент. Мы определяем какие контракты будут использоваться в группе и какие ресолверы будут определять нужен 
ли этот контракт для каждого текущего маршрута. Этот блок используется, когда вызывается консольная команда, которая 
покрывает тестами маршруты. Контракт обязует тест реализовать какую-либо логику, например, проверку передачи валидных данных, 
параметров и т.д. Далее есть подробное описание контрактов

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
Определяем какой миделвар отвечает за авторизацию в группе.

```php
'auth_middleware' => 'auth:sanctum',
```

Далее мы определяем ресолверы для получения дефолтного кода

```php
'code' => [
    'valid_data' => ValidDataCodeResolver::class,
    'invalid_data' => InvalidDataCodeResolver::class,
    'invalid_route_params' => InvalidRouteParamsResolver::class,
],
```

Затем для каждого пользователя нужно определить стратегию авторизации

```php
'auth' => [
    'guest' => WithoutAuthStrategy::class,
    'user' => SanctumAuthStrategy::class,
],
```

Это примеры из дефолтной группы. Параметры дефолтной группы применяютсвя к каждой группе, но в каждой группе мы можем 
переопределять эти данные.

Переходим к конфигурации по созданию документаии

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
                'path' => 'docs/api-docs/',
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

Выбираем какой рендерер будет использоваться при отображении документации. Сейчас доступен только swagger, но дальше их будет больше

```php
'renderer' => Renderer::SWAGGER,
```

Можем определить данными маршрутов для ui схемы и ее исходных данных. Можем определить миделвары для обоих маршрутов и каждого по отдельности,
а также имена и пути маршрутов.

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

Далее определяем версию OpenApi данные с основной информации и сервера

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

Затем переходим к авторизации. У нас уже есть список готовых схем авторизации, нужно выбрать нужную или добавить новые 
при необходимости

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

Далее данные по хранилищу. Определяем драйвер, место хранения данных по тестам и место и имя файла документации.

```php
'storage' => [
    'driver' => 'local',

    'data' => [
        'path' => 'swagger/data/',
    ],

    'docs' => [
        'name' => 'api-docs',
        'path' => 'docs/api-docs/',
    ],
],
```

Определяем коллекторы. Коллектор - это класс, который собирает данные по тестам и пишет рещультат в массив под определнным ключом.

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

далее мы определяем класс, который будет наполняться данными и из которого будет сформированна документация

```php
'dto' => OpenApi::class,
```

Затем определяем процессоры и их порядок. Процессор - анализриует собранные коллекторами данные и дополняет ими класс документации

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

После определения конфигурации переходим к созданию базовых классов по группам. Для каждой группы в каталоге тестов будет
создан свой подкаталог и базовый класс для тестов 

```bash
php artisan testrine:init
```

Затем создаем сами тесты. Для этого вызываем команду

```bash
php artisan testrine:tests
```

Команда покрывает маршруты тестами. Если нужно перезаписть можно использовать флаг -R

Либо можно использовать команду 

```bash
php artisan testrine:make
```

Для создания одного файла тестов

После создания тестов запускаем их

```bash
php artisan test
```

Затем анализируем собранные файлы

```bash
php artisan testrine:parse
```

Для удаления собранных файлов используем команду 

```bash
php artisan testrine:destroy
```

Можно использовать команду, которая объединяет в себе запуск тестов, анализ собранных данных и удлаение собранных данных

```bash
php artisan testrine:generate
```

Могут быть ситуации, когда нам нужно указать значение каких либо параметров маршрутов или данных в теле запроса или 
указать дефолтный код. Для этого нужно использовать бинды через класс DkDev\Testrine\Testrine и используем код билдер. 
Далее оно будет более детально описан.

Создание значений параметров маршрута. Мы определяем маршрут или можно для всех задать, для этого используем *.
И значение, можно использовать билдер, можно просто передать строку

```php
Testrine::binds()->pushValid(
    routeName: 'api.verification.verify',
    key: 'id',
    value: Builder::make()->method('getUser')->property('id'),
);
```

создание невалидного параметра маршрута

```php
Testrine::binds()->pushInvalid(
    routeName: 'api.verification.verify',
    key: 'id',
    value: Builder::make()->method('getUser')->property('id'),
);
```

создание дефолтного кода. Определяем ресолвер, роут и код

```php
Testrine::binds()->setDefaultCode(
    resolver: ValidDataCodeResolver::class,
    routeName: 'api.auth.logout',
    value: 204
);
```

создание дефолтного валидного значения. определяем роут/или для всех, ключ параметра и значение

```php
Testrine::binds()->setDefaultValue(
    routeName: 'api.auth.login',
    key: 'email',
    value: Builder::make()->method('getUser')->property('email'),
);
```

Контракты.

AssertContract. Применяется, когда нужно использовать сделать дополнительные проверки. Необходимо реализовать метод assert. 
Метод принимает текущий тест и ключ пользователя из-под которого тест выполняется.

```php
public function assert(TestResponse $test, string $userKey): void
{
    // todo
}
```

CodeContract. Применяется, когда нужно переопределить дефолтные успешные коды ответа. Необходимо реализовать метод codes, возвращает ассоциативный 
массив, где ключ это пользователь, а значение это код

```php
 public function codes(): array
{
    return [
        'guest' => 200,
        'user' => 200,
    ];
}
```

DocIgnoreContract. Применяется, когда нужно проигнорировать в документации этот тест. Ресолвер этого контракта имеет трейт 
HasContractRoutes, это значит, что для автоиспользования этого контракта для ресолвера можно задать маршруты.

```php
Testrine::binds()->setContractRoutes(
    contract: DocIgnoreContract::class,
    routes: [
        'api.home.index',
    ]
);
```

FakeStorageContract. Применяется, когда нужно вызвать Storage::fake() до теста. Ресолвер этого контракта имеет трейт
HasContractRoutes.

InvalidateCodeContract. Применяется. когда нужно использовать иной от дефолтного кода для невалидных данных. Нужно 
реализовать метод invalidDataCode

```php
public function invalidDataCode(): int
{
    return 301;
}
```

InvalidateContract. Контракт используется, если нужно проверить передачу невалидных данных. Необходимо реализовать метод
invalidData.

```php
public function invalidData(): array
{
    return [
        'name' => 123,
        'age' => 'fake'
    ]
}
```

InvalidParametersCodeContract. Применяется, когда нужно переопределить дефолитные коды для невалидных параметров маршрута.
Нужно реализовать метод codesForInvalidParameters.
```php
public function codesForInvalidParameters(): array
{
    return [
        'guest' => 403,
        'user' => 404,   
    ];
}
```
InvalidParametersContract. Применяется, когда нужно проверить передачу невалидных параметров маршрута. Необходимо реализовать 
метод invalidParameters

```php
public function invalidParameters(): array
{
    return [
        'post' => 'sadas'  
    ];
}
```

JobContract. Применяется, если нужно проверить работу джоб. Queue::fake() уже будет заранее вызван. 
Ресолвер этого контракта имеет трейт HasContractRoutes. Необходимо реализовать метод jobs, в котором проверить вызов джоб

```php
public function jobs(): void
{
    
}
```

MockContract. Применяется, если нужно вызвать моки над классами. Ресолвер этого контракта имеет трейт HasContractRoutes.
Необходимо реализовать метод mockAction, где делать все моки
```php
public function mockAction(): void
{

}
```

NotificationContract. Применяется, если нужно проверить вызов увеодмлений. Ресолвер этого контракта имеет трейт HasContractRoutes.
Нужно реализовать метод notifications
```php
public function notifications(): void
{

}
```

ParametersContract.Если нужно проверить передачу валидных параметров маршрута. 
```php
public function parameters(): array
{
    return [
        'post' => 1
    ];
}
```

ResponseContract. Если нужно проверить структуру ответа. Необходимо реализовать метод getResponseStructure
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

SeedContract. Если перед тестом нужно вызвать сидеры. Ресолвер этого контракта имеет трейт HasContractRoutes. Нужно 
реализовать dbSeed
```php
public function dbSeed(): void
{

}
```

ValidateContract. Если нужно проверить передачу валидных данных
```php
public function validData(): array
{
    return [
        'name' => 'fake_name',
        'age' => 21
    ];
}
```

Для формирования валидных данных используется генератор на основе правил валидации. Для различных правил есть свой обработчик.
Правила можно расширять. Для этого нужно создать класс наследник класс DkDev\Testrine\ValidData\Rules\BaseRule и реализовать 
его абстрактные методы getPriority, hasThisRule и getValue. Пример реализации правила 'email'.

```php
<?php

declare(strict_types=1);

namespace DkDev\Testrine\RequestPayload\Rules;

use DkDev\Testrine\Enums\ValidData\RulePriority;

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
        return 'fake()->email()';
    }
}
```

Затем нужно зарегистрировать новое правило.

```php
Testrine::rules()->add(NewRule::class);
```

Также можно полностью переопределить правила, очистить, получить список правил

```php
Testrine::rules()->set([
    RequiredRule::class,
    EmailRule::class,
]);

Testrine::rules()->clear();

$rules = Testrine::rules()->list();
```

Также можно кастомизировать стратегии авторизации, ресолверы контрактов, коллекторы, процессоры, ресолверы кодов и 
ClassNameBuilder, который автоматически формирует название класса. Для этого делаем бинды обработчика, обратныый вызов 
всегда получает текущий класс, для которого переопределяем логику.

```php
Testrine::binds()->setHandler(ClassNameBuilder::class, function (ClassNameBuilder $builder) {
    // todo 
});
```

Также мы можем задать обработчики для различных событий

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

// сработает только если тесты будут вызваны через testrine:generate
Testrine::handlers()->afterTests(function () {
    // todo   
});

// сработает только если тесты будут вызваны через testrine:generate
Testrine::handlers()->beforeTests(function () {
    // todo   
});
```

CodeBuilder. Через него мы можем:
- обратиться к текущему тесту
- вызвать свойство
- вызвать свойство с null-safe оператором
- вызвать метод
- вызвать метод с null-safe оператором
- вызвать функцию
- вызвать статическую функцию класса
- просто сделать возврат строки

```php
use DkDev\Testrine\CodeBuilder\Builder;

// строитель начнет с $this
Builder::make(); 

// обращаемся к методу getUser и получаем свойство email. Код будет следующим $this->getUser()->email;
Builder::make()->method('getUser')->property('email'); 

// тоже самое, но с null-safe оператором $this?->getUser()?->email;
Builder::make()->safeMethod('getUser')->safeProperty('email');

// вызов функции шифрования почты пользователя. Результат - sha1($this->getUser()->email);
Builder::make('')->func('sha1', Builder::make()->method('getUser')->property('email')), 

// возврат строки. Результат - 'password'
Builder::make('')->raw('password')
```
