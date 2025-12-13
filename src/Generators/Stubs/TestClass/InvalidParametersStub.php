<?php

declare(strict_types=1);

namespace DkDev\Testrine\Generators\Stubs\TestClass;

use DkDev\Testrine\Contracts\InvalidParametersContract;
use DkDev\Testrine\Generators\Stubs\TestClassStub;
use DkDev\Testrine\Helpers\Char;
use DkDev\Testrine\Helpers\RouteParameter;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Route;

class InvalidParametersStub extends TestClassStub
{
    public function getStubPath(): string
    {
        return 'test.method_invalid_parameters';
    }

    public function needUse(): bool
    {
        return $this->hasContract(InvalidParametersContract::class);
    }

    /**
     * @throws FileNotFoundException
     */
    public function getReplacementValue(): string
    {
        $uri = Route::getRoutes()->getByName($this->routeName)->uri();

        $result = \DkDev\Testrine\Helpers\Route::getParametersByUrl($uri)
            ->map(function (string $parameter, int $index) {
                $key = str_replace(['{', '}'], '', $parameter);
                $value = RouteParameter::makeInvalidValue($this->routeName, $key);

                return $index === 0 ? "'$key' => $value" : Char::TAB3."'$key' => $value";
            })->implode(','.Char::NL);

        return $this->makeResult('{{ parameters }}', $result);
    }
}
