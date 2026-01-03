<?php

declare(strict_types=1);

namespace DkDev\Testrine\ValidData\Traits;

use Stringable;

trait HasRange
{
    protected null|string|int $min = null;

    protected null|string|int $max = null;

    public function setRange(array $rules): void
    {
        foreach ($rules as $rule) {
            if (!is_string($rule) || !($rule instanceof Stringable)) {
                continue;
            }

            if (str($rule)->contains('min:')) {
                $this->min = str($rule)->after('min:')->value();
            }

            if (str($rule)->contains('max:')) {
                $this->max = $this->prepareMax(
                    str($rule)->after('max:')->value()
                );
            }

            if (str($rule)->contains('between:')) {
                $values = explode(',', str($rule)->after('max:')->value());

                $this->min = $values[0] ?? 0;
                $this->max = $this->prepareMax($values[1] ?? 0);
            }
        }

        if (empty($this->min)) {
            $this->min = 10;
        }

        if (empty($this->max)) {
            $this->max = 255;
        }
    }

    protected function prepareMax(string|int $value): string|int
    {
        return is_int($value) ? min($value, 750) : $value;
    }
}
