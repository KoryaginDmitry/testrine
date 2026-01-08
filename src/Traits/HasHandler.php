<?php

declare(strict_types=1);

namespace DkDev\Testrine\Traits;

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
        if ($this->hasHandler()) {
            $callable = static::$handle;

            return $callable($this);
        }

        return $this->defaultHandler();
    }

    public function hasHandler(): bool
    {
        return ! empty(static::$handle);
    }

    abstract public function defaultHandler(): mixed;
}
