<?php

declare(strict_types=1);

namespace DkDev\Testrine\Generators\Stubs\TestClass;

use DkDev\Testrine\Contracts\InvalidParametersCodeContract;
use DkDev\Testrine\Generators\Stubs\TestClassStub;
use DkDev\Testrine\Resolvers\Contract\InvalidateCodeResolver;
use DkDev\Testrine\Support\Char;
use DkDev\Testrine\Support\Infrastructure\Config;
use DkDev\Testrine\Support\Infrastructure\Route;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class InvalidParametersCodeStub extends TestClassStub
{
    public function getStubPath(): string
    {
        return 'test.method_invalid_parameters_codes';
    }

    public function needUse(): bool
    {
        return $this->hasContract(InvalidParametersCodeContract::class);
    }

    /**
     * @throws FileNotFoundException
     */
    public function getReplacementValue(): string
    {
        $result = collect(Config::getGroupValue($this->group, 'users'))
            ->map(function (string $user, int $index) {
                $code = InvalidateCodeResolver::make(route: Route::getRouteByName($this->routeName))->handle();

                return $index === 0 ? "'$user' => $code" : Char::TAB3."'$user' => $code";
            })->implode(','.Char::NL);

        return $this->makeResult('{{ default_codes }}', $result);
    }
}
