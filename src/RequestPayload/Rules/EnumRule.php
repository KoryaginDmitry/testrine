<?php

declare(strict_types=1);

namespace DkDev\Testrine\RequestPayload\Rules;

use BackedEnum;
use DkDev\Testrine\CodeBuilder\Builder;
use DkDev\Testrine\Enums\ValidData\RulePriority;
use Illuminate\Validation\Rules\Enum;
use ReflectionClass;

class EnumRule extends BaseRule
{
    protected array $in = [];

    public function getPriority(): RulePriority
    {
        return RulePriority::HIGH;
    }

    public function hasThisRule(): bool
    {
        /** @var Enum $rule */
        foreach ($this->rules as $rule) {
            if ($rule instanceof Enum) {
                $this->setInByEnumRule($rule);

                return true;
            }

            if ($this->startsWith('in:', $rule)) {
                $this->setInByInRule((string) $rule);

                return true;
            }
        }

        return false;
    }

    public function getValue(): string
    {
        return Builder::make('')
            ->func('collect', $this->in)
            ->method('random')
            ->build();
    }

    protected function setInByEnumRule(Enum $enum): void
    {
        $reflection = new ReflectionClass($enum);

        $property = $reflection->getProperty('type');
        $property->setAccessible(true);

        $type = $property->getValue($enum);

        $this->in = array_map(function ($case) {
            return $case instanceof BackedEnum
                ? $case->value
                : $case->name;
        }, $type::cases());
    }

    protected function setInByInRule(string $rule): void
    {
        $this->in = str($rule)->after(':')->explode(',')->toArray();
    }

    public function getInvalidValue(): string
    {
        return $this->randomStr();
    }
}
