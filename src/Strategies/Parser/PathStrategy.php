<?php

declare(strict_types=1);

namespace DkDev\Testrine\Strategies\Parser;

use Illuminate\Support\Collection;
use Illuminate\Testing\TestResponse;

class PathStrategy extends BaseParserStrategy
{
    public function getName(): string
    {
        return 'path';
    }

    public function analyze(TestResponse $response, Collection $attributes): mixed
    {
        return str($this->getRoute()?->uri)->replace('?', '')->start('/')->value();
    }
}
