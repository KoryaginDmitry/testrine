<?php

declare(strict_types=1);

namespace DkDev\Testrine\Generators\Stubs\TestClass;

use DkDev\Testrine\Contracts\NotificationContract;
use DkDev\Testrine\Generators\Stubs\TestClassStub;
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
