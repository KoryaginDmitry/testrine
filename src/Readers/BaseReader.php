<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Readers;

abstract class BaseReader
{
    abstract public function read(string $path): array;
}
