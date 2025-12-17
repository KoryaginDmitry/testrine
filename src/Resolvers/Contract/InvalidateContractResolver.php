<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Resolvers\Contract;

use Illuminate\Foundation\Http\FormRequest;

class InvalidateContractResolver extends ContractResolver
{
    public function defaultHandler(): bool
    {
        return \Dkdev\Testrine\Support\Infrastructure\Route::hasInjection(route: $this->route, injection: FormRequest::class);
    }
}
