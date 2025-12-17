<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Generators\Stubs\TestClass;

use Dkdev\Testrine\Contracts\NotificationContract;
use Dkdev\Testrine\Generators\Stubs\TestClassStub;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class NotificationStub extends TestClassStub
{
    public function getStubPath(): string
    {
        return 'test.method_notifications';
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
        return $this->hasContract(NotificationContract::class);
    }
}
