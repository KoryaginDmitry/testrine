<?php

declare(strict_types=1);

namespace DkDev\Testrine\CodeBuilder\Nodes;

class StaticNode extends BaseNode
{
    public function __construct(
        public string $class,
        public string $method,
        public array $args
    ) {}

    public function render(): string
    {
        return "\\$this->class::{$this->method}({$this->prepareArgs()})";
    }
}
