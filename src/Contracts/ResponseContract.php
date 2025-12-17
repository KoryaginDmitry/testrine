<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Contracts;

interface ResponseContract
{
    public function getResponseStructure(): array;
}
