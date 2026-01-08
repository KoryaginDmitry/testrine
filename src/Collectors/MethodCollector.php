<?php

declare(strict_types=1);

namespace DkDev\Testrine\Collectors;

class MethodCollector extends Collector
{
    public function getName(): string
    {
        return 'method';
    }

    public function defaultHandler(): string
    {
        return str($this->getRoute()?->methods()[0])->lower()->value();
    }
}
