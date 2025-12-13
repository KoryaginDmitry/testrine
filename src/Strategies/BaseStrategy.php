<?php

declare(strict_types=1);

namespace DkDev\Testrine\Strategies;

use DkDev\Testrine\Traits\Makeable;

/**
 * @method static static make()
 */
abstract class BaseStrategy
{
    use Makeable;

    /** @var null|callable */
    public static $handle = null;

    public static function setHandler(callable $callback): void
    {
        self::$handle = $callback;
    }
}
