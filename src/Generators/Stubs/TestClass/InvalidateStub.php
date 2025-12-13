<?php

declare(strict_types=1);

namespace DkDev\Testrine\Generators\Stubs\TestClass;

use DkDev\Testrine\Contracts\InvalidateContract;
use DkDev\Testrine\Generators\Stubs\TestClassStub;
use DkDev\Testrine\Helpers\Char;
use DkDev\Testrine\Helpers\Reflection;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Route;
use ReflectionException;

class InvalidateStub extends TestClassStub
{
    public function getStubPath(): string
    {
        return 'test.method_invalidate';
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
            ->map(fn (array|string $rules, string $key) => "'$key' => '',\n\t\t\t")
            ->implode(value: '');

        return $this->makeResult(key: '{{ data }}', value: rtrim(string: $result, characters: Char::NL_TAB3));
    }

    public function needUse(): bool
    {
        return $this->hasContract(contract: InvalidateContract::class);
    }
}
