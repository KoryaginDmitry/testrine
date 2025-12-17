<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Collectors;

use Dkdev\Testrine\Traits\HasHandler;
use Dkdev\Testrine\Traits\Makeable;
use Illuminate\Routing\Route;
use Illuminate\Support\Collection;
use Illuminate\Testing\TestResponse;

abstract class Collector
{
    use HasHandler;
    use Makeable;

    public function __construct(
        protected TestResponse $response,
        protected Collection $attributes
    ) {}

    abstract public function getName(): string;

    protected function getRoute(): ?Route
    {
        return request()->route();
    }
}
