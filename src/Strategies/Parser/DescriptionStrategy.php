<?php

declare(strict_types=1);

namespace DkDev\Testrine\Strategies\Parser;

use DkDev\Testrine\Attributes\Description;
use Illuminate\Support\Collection;
use Illuminate\Testing\TestResponse;

class DescriptionStrategy extends BaseParserStrategy
{
    public function getName(): string
    {
        return 'description';
    }

    public function analyze(TestResponse $response, Collection $attributes): mixed
    {
        return $attributes
            ->filter(fn ($item) => $item instanceof Description)
            ->last()
            ?->description;
    }
}
