<?php

declare(strict_types=1);

namespace DkDev\Testrine\Helpers;

use Closure;
use Illuminate\Support\Stringable;

class GetClassName
{
    public static ?Closure $handler = null;

    public static function handle(string $routeName, string $group): string
    {
        if (self::$handler) {
            return self::$handler($routeName, $group);
        }

        return self::default(routeName: $routeName, group: $group);
    }

    protected static function default(string $routeName, string $group): string
    {
        $classPath = str($routeName)
            ->when(
                value: str_starts_with($routeName, $group.'.'),
                callback: fn (Stringable $str) => $str->replaceFirst(search: "$group.", replace: '')
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
