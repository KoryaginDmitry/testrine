<?php

declare(strict_types=1);

namespace DkDev\Testrine\Resolvers\Contract;

use Illuminate\Foundation\Http\FormRequest;

class InvalidateContractResolver extends ContractResolver
{
    public function defaultHandler(): bool
    {
        return \DkDev\Testrine\Support\Infrastructure\Route::hasInjection(route: $this->route, injection: FormRequest::class);
    }
}
