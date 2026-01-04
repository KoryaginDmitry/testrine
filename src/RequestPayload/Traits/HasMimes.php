<?php

declare(strict_types=1);

namespace DkDev\Testrine\RequestPayload\Traits;

trait HasMimes
{
    public array $mimes = [];

    public function setMimes(array $rules): void
    {
        foreach ($rules as $rule) {
            if (str((string) $rule)->contains('mimes:')) {
                $this->mimes = str((string) $rule)->after('mimes:')->explode(',')->toArray();
            }
        }
    }
}
