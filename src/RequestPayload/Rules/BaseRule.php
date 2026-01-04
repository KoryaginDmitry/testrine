<?php

declare(strict_types=1);

namespace DkDev\Testrine\RequestPayload\Rules;

use DkDev\Testrine\CodeBuilder\Builder;
use DkDev\Testrine\Enums\ValidData\RulePriority;
use DkDev\Testrine\Traits\Makeable;
use Illuminate\Routing\Route;
use Stringable;

/**
 * @method static BaseRule make(Route $route, string $key, array $rules)
 */
abstract class BaseRule
{
    use Makeable;

    private static array $defaultValue = [];

    public function __construct(
        protected Route $route,
        protected string $key,
        protected array $rules,
    ) {}

    abstract public function getPriority(): RulePriority;

    abstract public function hasThisRule(): bool;

    abstract public function getValue(): string;

    public function makeResult(): string
    {
        return $this->hasDefaultValue() ? $this->getDefaultValue() : $this->getValue();
    }

    public static function setDefaultValue(string $routeName, string $key, int|string|Builder $value): void
    {
        $value = $value instanceof Builder ? $value->build() : $value;

        self::$defaultValue["{$routeName}_$key"] = $value;
    }

    protected function hasDefaultValue(): bool
    {
        return isset(self::$defaultValue["*_$this->key"])
            || isset(self::$defaultValue["{$this->route->getName()}_$this->key"]);
    }

    protected function getDefaultValue(): int|string
    {
        return self::$defaultValue["{$this->route->getName()}_$this->key"]
            ?? self::$defaultValue["*_$this->key"];
    }

    protected function inRules(string $value): bool
    {
        return in_array($value, $this->rules);
    }

    protected function hasInstance(string $class): bool
    {
        return ! empty(
            array_filter($this->rules, fn ($rule) => $rule instanceof $class)
        );
    }

    protected function startsWith(string $value, mixed $rule): bool
    {
        return (is_string($rule) || $rule instanceof Stringable) && str_starts_with((string) $rule, $value);
    }

    protected function contains(string $value, mixed $rule): bool
    {
        return (is_string($rule) || $rule instanceof Stringable) && str((string) $rule)->contains($value);
    }
}
