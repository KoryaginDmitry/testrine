<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Support\Builders;

use Dkdev\Testrine\Traits\HasHandler;
use Dkdev\Testrine\Traits\Makeable;
use Illuminate\Support\Stringable;

/**
 * @method static ClassNameBuilder make(string $routeName, string $group)
 */
class ClassNameBuilder
{
    use HasHandler;
    use Makeable;

    public function __construct(
        protected string $routeName,
        protected string $group
    ) {}

    public function defaultHandler(): string
    {
        $classPath = str($this->routeName)
            ->when(
                value: str_starts_with($this->routeName, $this->group.'.'),
                callback: fn (Stringable $str) => $str->replaceFirst(search: "$this->group.", replace: '')
            )->explode('.')
            ->map(fn (string $value, int $index) => str($value)->camel()->ucfirst())
            ->implode(DIRECTORY_SEPARATOR);

        $result = str($classPath)->when(
            value: ! str_ends_with($classPath, 'Test'),
            callback: fn ($str) => $str.'Test'
        );

        return is_string($result) ? $result : $result->value();
    }
}
