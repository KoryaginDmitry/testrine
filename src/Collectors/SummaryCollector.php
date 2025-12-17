<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Collectors;

use Dkdev\Testrine\Attributes\Summary;

class SummaryCollector extends Collector
{
    public function getName(): string
    {
        return 'summary';
    }

    public function defaultHandler(): mixed
    {
        return $this->attributes
            ->filter(fn ($item) => $item instanceof Summary)
            ->last()
            ?->summary;
    }
}
