<?php

declare(strict_types=1);

namespace DkDev\Testrine\Hooks;

use DkDev\Testrine\Contracts\FakeStorageContract;
use DkDev\Testrine\Contracts\MockContract;
use Illuminate\Support\Facades\Storage;

class MockHook extends BaseHook
{
    public function run(): void
    {
        if ($this->implements(contract: FakeStorageContract::class)) {
            Storage::fake(disk: 'public');
        }

        if ($this->implements(contract: MockContract::class)) {
            call_user_func([$this->test, 'mockAction']);
        }
    }
}
