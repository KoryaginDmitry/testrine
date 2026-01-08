<?php

declare(strict_types=1);

namespace DkDev\Testrine\Services;

use DkDev\Testrine\Resolvers\Code\CodeResolver;

class CodeService extends BaseService
{
    public function setDefaultCode(string $resolver, string $routeName, int $value): void
    {
        CodeResolver::setDefaultCode(resolver: $resolver, routeName: $routeName, code: $value);
    }

    public function getDefaultCode(string $resolver, string $routeName): ?int
    {
        return CodeResolver::getDefaultCode($resolver, $routeName);
    }
}
