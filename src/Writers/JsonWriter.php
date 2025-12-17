<?php

declare(strict_types=1);

namespace DkDev\Testrine\Writers;

use DkDev\Testrine\Support\Infrastructure\StorageHelper;

class JsonWriter extends BaseWriter
{
    public function write(string $path, string $name, array $data): void
    {
        StorageHelper::driver()
            ->put(
                path: $this->getFullName($path, $name, 'json'),
                contents: $this->encodeJson($data),
            );
    }

    protected function encodeJson(array $data): string
    {
        return collect($data)->toJson();
    }
}
