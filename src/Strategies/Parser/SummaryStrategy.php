<?php

declare(strict_types=1);

namespace DkDev\Testrine\Strategies\Parser;

use DkDev\Testrine\Attributes\Summary;
use Illuminate\Support\Collection;
use Illuminate\Testing\TestResponse;

class SummaryStrategy extends BaseParserStrategy
{
    public function getName(): string
    {
        return 'summary';
    }

    public function analyze(TestResponse $response, Collection $attributes): mixed
    {
        return $attributes
            ->filter(fn ($item) => $item instanceof Summary)
            ->last()
            ?->summary;
    }
}
