<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Traits;

trait Makeable
{
    public static function make(...$args): static
    {
        return new static(...$args);
    }
}
