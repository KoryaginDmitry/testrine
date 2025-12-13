<?php

declare(strict_types=1);

namespace DkDev\Testrine\Generators\Stubs\TestClass;

use DkDev\Testrine\Contracts\MockContract;
use DkDev\Testrine\Generators\Stubs\TestClassStub;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class MockStub extends TestClassStub
{
    public function getStubPath(): string
    {
        return 'test.method_mockAction';
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
        return $this->hasContract(MockContract::class);
    }
}
