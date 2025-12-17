<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Generators\Stubs\TestClass;

use Dkdev\Testrine\Contracts\SeedContract;
use Dkdev\Testrine\Generators\Stubs\TestClassStub;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class SeedStub extends TestClassStub
{
    public function getStubPath(): string
    {
        return 'test.method_seed';
    }

    /**
     * @throws FileNotFoundException
     */
    public function getReplacementValue(): string
    {
        return $this->getStub();
    }

    public function needUse(): bool
    {
        return $this->hasContract(contract: SeedContract::class);
    }
}
