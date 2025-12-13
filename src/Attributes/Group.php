<?php

namespace DkDev\Testrine\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_CLASS)]
class Group
{
    public function __construct(
        public string $name
    ) {}
}
