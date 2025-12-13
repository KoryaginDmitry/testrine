<?php

declare(strict_types=1);

namespace DkDev\Testrine\Generators\Stubs;

use DkDev\Testrine\Generators\TestGenerator;
use DkDev\Testrine\Helpers\Char;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

/** @mixin TestGenerator */
abstract class TestClassStub extends BaseStub
{
    abstract public function needUse(): bool;

    /**
     * @throws FileNotFoundException
     */
    protected function makeResult(string|array $key, string|array $value): string
    {
        return str_replace($key, $value, $this->getStub()).Char::NL;
    }

    protected function hasContract(string $contract): bool
    {
        return in_array($contract, $this->contracts);
    }
}
