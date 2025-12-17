<?php

declare(strict_types=1);

namespace DkDev\Testrine\Generators\Stubs\TestClass;

use DkDev\Testrine\Contracts\ValidateContract;
use DkDev\Testrine\Generators\Stubs\TestClassStub;
use DkDev\Testrine\Support\Char;
use DkDev\Testrine\Support\Infrastructure\Reflection;
use DkDev\Testrine\ValidData\ValidData;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Route;
use ReflectionException;

class ValidateStub extends TestClassStub
{
    public function getStubPath(): string
    {
        return 'test.method_validate';
    }

    /**
     * @throws ReflectionException
     * @throws FileNotFoundException
     */
    public function getReplacementValue(): string
    {
        $route = Route::getRoutes()->getByName(name: $this->routeName);

        if (! empty($route->getAction()['controller'])) {
            $rules = Reflection::make(route: $route)->getFormRequestRules();
        }

        $result = collect($rules ?? [])
            ->map(fn (array|string $rules, string $key) => ValidData::make()->generate(route: $route, key: $key, rules: $rules))
            ->values()
            ->implode('');

        return $this->makeResult(key: '{{ data }}', value: rtrim($result, Char::NL_TAB3));
    }

    public function needUse(): bool
    {
        return $this->hasContract(contract: ValidateContract::class);
    }
}
