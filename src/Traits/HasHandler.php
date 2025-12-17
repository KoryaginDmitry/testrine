<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Traits;

use Closure;

trait HasHandler
{
    public static Closure $handle;

    public static function setHandler(Closure $callback): void
    {
        self::$handle = $callback;
    }

    public function handle()
    {
        if (! empty(static::$handle)) {
            $callable = static::$handle;

            return $callable($this);
        }

        return $this->defaultHandler();
    }

    abstract public function defaultHandler(): mixed;
}
