<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Generators\Stubs\TestClass;

use Dkdev\Testrine\Generators\Stubs\TestClassStub;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class RouteMiddlewareStub extends TestClassStub
{
    public function getStubPath(): string
    {
        return 'test.method_route_middleware';
    }

    public function needUse(): bool
    {
        return true;
    }

    /**
     * @throws FileNotFoundException
     */
    public function getReplacementValue(): string
    {
        $result = str($this->middlewares)
            ->trim(',')
            ->explode(', ')
            ->map(fn (string $middleware) => "'$middleware'")
            ->implode(',');

        return $this->makeResult(['{{ route }}', '{{ middleware }}'], [$this->routeName, $result]);
    }
}
