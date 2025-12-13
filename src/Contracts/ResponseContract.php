<?php

declare(strict_types=1);

namespace DkDev\Testrine\Contracts;

interface ResponseContract
{
    public function getResponseStructure(): array;
}
