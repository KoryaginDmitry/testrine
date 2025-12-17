<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Generators\Stubs;

use Dkdev\Testrine\Generators\BaseClassGenerator;
use Dkdev\Testrine\Support\Char;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

/** @mixin BaseClassGenerator */
abstract class BaseClassStub extends BaseStub
{
    abstract public function getReplacementKey(): string;

    /**
     * @throws FileNotFoundException
     */
    protected function pushResult(array $keys, array $values): void
    {
        $stub = trim(str_replace($keys, $values, $this->getStub()));

        if ($this->result !== '') {
            $this->result = rtrim($this->result, Char::NL).Char::NL2_TAB;
        }

        $this->result .= $stub;
    }

    protected function makeResult(): string
    {
        return rtrim($this->result, Char::NL);
    }
}
