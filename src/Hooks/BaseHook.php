<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Hooks;

use Dkdev\Testrine\BaseTestrineCase;
use Dkdev\Testrine\Traits\Makeable;
use Illuminate\Support\Collection;

/**
 * @mixin BaseTestrineCase
 *
 * @method static BaseHook make(BaseTestrineCase $test, $args = [])
 */
abstract class BaseHook
{
    use Makeable;

    protected Collection $args;

    public function __construct(
        protected BaseTestrineCase $test,
        array $args = [],
    ) {
        $this->args = collect($args);
    }

    protected function implements(string $contract): bool
    {
        return is_a(object_or_class: $this->test, class: $contract);
    }

    public function __get(string $name)
    {
        return $this->test->{$name};
    }

    public function __call(string $name, array $arguments)
    {
        return $this->test->{$name}(...$arguments);
    }

    abstract public function run();
}
