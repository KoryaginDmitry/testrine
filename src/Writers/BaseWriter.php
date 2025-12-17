<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Writers;

abstract class BaseWriter
{
    abstract public function write(string $path, string $name, array $data): void;

    protected function getFullName(string $path, string $name, string $extensions): string
    {
        return str($path)->finish('/').ltrim($name, '/').'.'.$extensions;
    }
}
