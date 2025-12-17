<?php

declare(strict_types=1);

namespace Dkdev\Testrine\CodeBuilder;

use Dkdev\Testrine\CodeBuilder\Nodes\FunctionNode;
use Dkdev\Testrine\CodeBuilder\Nodes\MethodNode;
use Dkdev\Testrine\CodeBuilder\Nodes\PropertyNode;
use Dkdev\Testrine\CodeBuilder\Nodes\RawNode;
use Dkdev\Testrine\CodeBuilder\Nodes\SafeMethodNode;
use Dkdev\Testrine\CodeBuilder\Nodes\SafePropertyNode;
use Dkdev\Testrine\CodeBuilder\Nodes\StaticNode;
use Dkdev\Testrine\Traits\Makeable;

/** @method static Builder make(string $root = '$this') */
class Builder
{
    use Makeable;

    protected array $nodes = [];

    protected string $root;

    public function __construct(string $root = '$this')
    {
        $this->root = $root;
    }

    public static function from(string $root): static
    {
        return new static($root);
    }

    public function property(string $name): static
    {
        $this->nodes[] = new PropertyNode($name);

        return $this;
    }

    public function safeProperty(string $name): static
    {
        $this->nodes[] = new SafePropertyNode($name);

        return $this;
    }

    public function method(string $name, ...$args): static
    {
        $this->nodes[] = new MethodNode($name, $args);

        return $this;
    }

    public function safeMethod(string $name, ...$args): static
    {
        $this->nodes[] = new SafeMethodNode($name, $args);

        return $this;
    }

    public function func(string $name, ...$args): static
    {
        $this->nodes[] = new FunctionNode($name, $args);

        return $this;
    }

    public function staticCall(string $class, string $method, ...$args): static
    {
        $this->nodes[] = new StaticNode($class, $method, $args);

        return $this;
    }

    public function raw(string $code): static
    {
        $this->nodes[] = new RawNode($code);

        return $this;
    }

    public function build(): string
    {
        return Renderer::make()->render($this->root, $this->nodes);
    }
}
