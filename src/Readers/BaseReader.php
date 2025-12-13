<?php

declare(strict_types=1);

namespace DkDev\Testrine\Readers;

abstract class BaseReader
{
    abstract public function read(string $path): array;
}
