<?php

declare(strict_types=1);

namespace DkDev\Testrine\Strategies\Parser;

use Illuminate\Support\Collection;
use Illuminate\Testing\TestResponse;

class MethodStrategy extends BaseParserStrategy
{
    public function getName(): string
    {
        return 'method';
    }

    public function analyze(TestResponse $response, Collection $attributes): mixed
    {
        return str($this->getRoute()?->methods()[0])->lower()->value();
    }
}
