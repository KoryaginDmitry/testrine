<?php

declare(strict_types=1);

namespace DkDev\Testrine\Generators\Stubs\TestClass;

use DkDev\Testrine\Contracts\ResponseContract;
use DkDev\Testrine\Generators\Stubs\TestClassStub;
use DkDev\Testrine\Support\Infrastructure\Reflection;
use DkDev\Testrine\Support\Infrastructure\ResourceModelResolver;
use DkDev\Testrine\Support\Infrastructure\ResourceResponseBuilder;
use DkDev\Testrine\Support\Infrastructure\Route;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Resources\Json\JsonResource;
use ReflectionException;

class ResponseStub extends TestClassStub
{
    public function getStubPath(): string
    {
        return 'test.method_response';
    }

    /**
     * @throws ReflectionException
     * @throws FileNotFoundException
     */
    public function getReplacementValue(): string
    {
        $route = Route::getRouteByName($this->routeName);

        [$resourceClass, $isCollection] = Reflection::make($route)->getJsonResourceClass();

        if (! $resourceClass || ! class_exists($resourceClass)) {
            return $this->makeResult('{{ response_keys }}', '// todo add response keys');
        }

        /** @var JsonResource $resource */
        $resource = new $resourceClass(
            ResourceModelResolver::make($resourceClass)->findModel()
        );

        return $this->makeResult('{{ resource_keys }}', ResourceResponseBuilder::make($resource, $isCollection)->build());
    }

    public function needUse(): bool
    {
        return $this->hasContract(ResponseContract::class);
    }
}
