<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Resolvers\Contract;

use Dkdev\Testrine\Support\Infrastructure\Route;
use Illuminate\Foundation\Http\FormRequest;

class ValidateContractResolver extends ContractResolver
{
    public function defaultHandler(): bool
    {
        return Route::hasInjection(route: $this->route, injection: FormRequest::class);
    }
}
