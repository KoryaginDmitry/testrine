<?php

declare(strict_types=1);

namespace DkDev\Testrine\Traits;

use Closure;

trait HasHandler
{
    /**
     * @var array<class-string, Closure>
     */
    protected static array $handlers = [];

    public static function setHandler(Closure $callback): void
    {
        static::$handlers[static::class] = $callback;
    }

    public function handle(): mixed
    {
        if ($this->hasHandler()) {
            return static::$handlers[static::class]($this);
        }

        return $this->defaultHandler();
    }

    public function hasHandler(): bool
    {
        return array_key_exists(static::class, static::$handlers);
    }

    abstract public function defaultHandler(): mixed;
}
