<?php

declare(strict_types=1);

namespace DkDev\Testrine\Doc;

abstract class BaseDoc
{
    abstract public static function fromArray(array $data): static;
}
