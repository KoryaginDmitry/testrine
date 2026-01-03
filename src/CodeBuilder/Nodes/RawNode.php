<?php

declare(strict_types=1);

namespace DkDev\Testrine\CodeBuilder\Nodes;

class RawNode extends BaseNode
{
    public function __construct(
        public string $code,
        public bool $escape = true
    ) {}

    public function render(): string
    {
        return $this->escape ? "'$this->code'" : $this->code;
    }
}
