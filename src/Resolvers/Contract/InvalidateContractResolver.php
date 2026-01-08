<?php

declare(strict_types=1);

namespace DkDev\Testrine\Resolvers\Contract;

use DkDev\Testrine\Support\Infrastructure\Route;
use Illuminate\Foundation\Http\FormRequest;

class InvalidateContractResolver extends ContractResolver
{
    public function defaultHandler(): bool
    {
        return Route::hasInjection(route: $this->route, injection: FormRequest::class);
    }
}
