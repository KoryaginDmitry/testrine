<?php

namespace DkDev\Testrine\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class Summary
{
    public function __construct(
        public string $summary
    ) {}
}
