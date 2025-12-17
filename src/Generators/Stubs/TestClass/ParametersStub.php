<?php

declare(strict_types=1);

namespace DkDev\Testrine\Generators\Stubs\TestClass;

use DkDev\Testrine\Contracts\ParametersContract;
use DkDev\Testrine\Generators\Stubs\TestClassStub;
use DkDev\Testrine\Support\Char;
use DkDev\Testrine\Testrine;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Route;

class ParametersStub extends TestClassStub
{
    public function getStubPath(): string
    {
        return 'test.method_parameters';
    }

    public function needUse(): bool
    {
        return $this->hasContract(ParametersContract::class);
    }

    /**
     * @throws FileNotFoundException
     */
    public function getReplacementValue(): string
    {
        $uri = Route::getRoutes()->getByName($this->routeName)->uri();

        $result = \DkDev\Testrine\Support\Infrastructure\Route::getParametersByUrl($uri)
            ->map(function (string $parameter, int $index) {
                $key = str_replace(['{', '}'], '', $parameter);
                $value = Testrine::binds()->getValid($this->routeName, $key);

                return $index === 0 ? "'$key' => $value" : Char::TAB3."'$key' => $value";
            })->implode(','.Char::NL);

        return $this->makeResult('{{ parameters }}', $result);
    }
}
