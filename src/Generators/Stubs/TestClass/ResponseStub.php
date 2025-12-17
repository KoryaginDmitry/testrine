<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Generators\Stubs\TestClass;

use Dkdev\Testrine\Contracts\ResponseContract;
use Dkdev\Testrine\Generators\Stubs\TestClassStub;
use Dkdev\Testrine\Support\Infrastructure\Reflection;
use Dkdev\Testrine\Support\Infrastructure\ResourceModelResolver;
use Dkdev\Testrine\Support\Infrastructure\ResourceResponseBuilder;
use Dkdev\Testrine\Support\Infrastructure\Route;
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
