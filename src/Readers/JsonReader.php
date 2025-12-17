<?php

declare(strict_types=1);

namespace DkDev\Testrine\Readers;

use DkDev\Testrine\Support\Infrastructure\StorageHelper;

class JsonReader extends BaseReader
{
    public function read(string $path): array
    {
        return StorageHelper::driver()->json($path);
    }
}
