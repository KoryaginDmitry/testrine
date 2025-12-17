<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Readers;

use Dkdev\Testrine\Support\Infrastructure\StorageHelper;

class JsonReader extends BaseReader
{
    public function read(string $path): array
    {
        return StorageHelper::driver()->json($path);
    }
}
