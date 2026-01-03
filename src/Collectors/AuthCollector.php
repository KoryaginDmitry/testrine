<?php

declare(strict_types=1);

namespace DkDev\Testrine\Collectors;

use DkDev\Testrine\Support\Infrastructure\Config;

class AuthCollector extends Collector
{
    public function getName(): string
    {
        return 'auth';
    }

    public function defaultHandler(): mixed
    {
        return in_array(Config::getGroupValue($this->group, 'auth_middleware'), $this->getRoute()?->middleware(), true);
    }
}
