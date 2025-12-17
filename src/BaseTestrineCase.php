<?php

namespace Dkdev\Testrine;

use Dkdev\Testrine\Hooks\BaseHook;
use Illuminate\Routing\Route;
use Tests\TestCase;

abstract class BaseTestrineCase extends TestCase
{
    abstract public function getGroupName(): string;

    abstract public function getRouteName(): string;

    abstract public function getMiddleware(): array;

    protected string $userKey;

    protected function setUserKey(string $userKey): void
    {
        $this->userKey = $userKey;
    }

    public function getUserKey(): string
    {
        return $this->userKey;
    }

    protected function implements(string $contract): bool
    {
        return is_a(object_or_class: $this, class: $contract);
    }

    protected function getRouteByName(): Route
    {
        $route = \Illuminate\Support\Facades\Route::getRoutes()
            ->getByName(name: $this->getRouteName());

        if (! $route) {
            $this->fail(__(key: 'testrine:console.test.errors.route.not_found', replace: [
                ':route_name' => $this->getRouteName(),
            ]));
        }

        return $route;
    }

    protected function assertRouteContainsMiddleware(array $names): void
    {
        $route = $this->getRouteByName();

        foreach ($names as $name) {
            $this->assertContains(
                needle: $name,
                haystack: $route->middleware(),
                message: __(key: 'testrine:console.test.errors.route.not_contain_middlewares', replace: [
                    'name' => $name,
                ]),
            );
        }
    }

    protected function assertRouteHasExactMiddleware(array $names): void
    {
        $route = $this->getRouteByName();

        $this->assertRouteContainsMiddleware(names: $names);

        $this->assertCount(
            expectedCount: count($names),
            haystack: $route->middleware(),
            message: __(key: 'testrine:console.test.errors.route.different_amount_middlewares')
        );
    }

    /**
     * @param  class-string<BaseHook>  $hook
     */
    protected function executeHook(string $hook, array $args = [])
    {
        return $hook::make(test: $this, args: $args)->run();
    }
}
