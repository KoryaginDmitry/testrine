<?php

declare(strict_types=1);

namespace DkDev\Testrine\Collectors;

use DkDev\Testrine\Attributes\Description;

class DescriptionCollector extends Collector
{
    public function getName(): string
    {
        return 'description';
    }

    public function defaultHandler(): mixed
    {
        return $this->attributes
            ->filter(fn ($item) => $item instanceof Description)
            ->last()
            ?->description;
    }
}
