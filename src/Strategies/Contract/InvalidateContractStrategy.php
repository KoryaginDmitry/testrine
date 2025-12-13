<?php

declare(strict_types=1);

namespace DkDev\Testrine\Strategies\Contract;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Routing\Route;
use ReflectionException;

class InvalidateContractStrategy extends BaseContractStrategy
{
    /**
     * @throws ReflectionException
     */
    public function needUse(Route $route): bool
    {
        return \DkDev\Testrine\Helpers\Route::hasInjection(route: $route, injection: FormRequest::class);
    }
}
