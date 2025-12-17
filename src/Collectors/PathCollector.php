<?php

declare(strict_types=1);

namespace DkDev\Testrine\Collectors;

class PathCollector extends Collector
{
    public function getName(): string
    {
        return 'path';
    }

    public function defaultHandler(): mixed
    {
        return str($this->getRoute()?->uri)->replace('?', '')->start('/')->value();
    }
}
