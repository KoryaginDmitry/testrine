<?php

declare(strict_types=1);

namespace DkDev\Testrine\Strategies\Parser;

use DkDev\Testrine\Strategies\BaseStrategy;
use Illuminate\Routing\Route;
use Illuminate\Support\Collection;
use Illuminate\Testing\TestResponse;

abstract class BaseParserStrategy extends BaseStrategy
{
    public function handle(TestResponse $response, Collection $attributes): mixed
    {
        if (! empty(static::$handle)) {
            $callable = static::$handle;

            // todo а что если закидывать текущий класс
            return $callable($response, $attributes);
        }

        return $this->analyze(response: $response, attributes: $attributes);
    }

    abstract public function getName(): string;

    abstract public function analyze(TestResponse $response, Collection $attributes): mixed;

    protected function getRoute(): ?Route
    {
        return request()->route();
    }
}
