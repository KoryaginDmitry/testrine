<?php

declare(strict_types=1);

namespace DkDev\Testrine\Generators\Stubs\TestClass;

use DkDev\Testrine\Contracts\InvalidateCodeContract;
use DkDev\Testrine\Generators\Stubs\TestClassStub;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class InvalidCodeStub extends TestClassStub
{
    public function getStubPath(): string
    {
        return 'test.method_invalid_data_code';
    }

    public function needUse(): bool
    {
        return $this->hasContract(InvalidateCodeContract::class);
    }

    /**
     * @throws FileNotFoundException
     */
    public function getReplacementValue(): string
    {
        return $this->getStub();
    }
}
