<?php

declare(strict_types=1);

namespace DkDev\Testrine\Generators\Stubs\TestClass;

use DkDev\Testrine\Contracts\InvalidParametersCodeContract;
use DkDev\Testrine\Generators\Stubs\TestClassStub;
use DkDev\Testrine\Helpers\Char;
use DkDev\Testrine\Helpers\Config;
use DkDev\Testrine\Helpers\Route;
use DkDev\Testrine\Strategies\Contract\InvalidateCodeStrategy;
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
                $code = InvalidateCodeStrategy::make()->handle(Route::getRouteByName($this->routeName));

                return $index === 0 ? "'$user' => $code" : Char::TAB3."'$user' => $code";
            })->implode(','.Char::NL);

        return $this->makeResult('{{ default_codes }}', $result);
    }
}
