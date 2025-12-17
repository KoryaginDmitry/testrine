<?php

declare(strict_types=1);

namespace DkDev\Testrine\CodeBuilder\Nodes;

class RawNode extends BaseNode
{
    public function __construct(
        public string $code
    ) {}

    public function render(): string
    {
        return "'$this->code'";
    }
}
