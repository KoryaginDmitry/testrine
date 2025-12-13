<?php

namespace DkDev\Testrine\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class Description
{
    public function __construct(
        public string $description
    ) {}
}
