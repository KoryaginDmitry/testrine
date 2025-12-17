<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Collectors;

use Dkdev\Testrine\Support\Infrastructure\Config;

class AuthCollector extends Collector
{
    public function getName(): string
    {
        return 'auth';
    }

    public function defaultHandler(): mixed
    {
        return in_array(Config::getSwaggerValue('auth.middleware'), $this->getRoute()?->middleware(), true);
    }
}
