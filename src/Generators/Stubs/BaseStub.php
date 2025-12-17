<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Generators\Stubs;

use Dkdev\Testrine\Generators\BaseGenerator;
use Dkdev\Testrine\Support\Stub;
use Dkdev\Testrine\Traits\Makeable;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

/**
 * @method static BaseStub make(BaseGenerator $generator)
 */
abstract class BaseStub
{
    use Makeable;

    protected string $result = '';

    public function __construct(protected BaseGenerator $generator) {}

    abstract public function getStubPath(): string;

    abstract public function getReplacementValue(): string;

    public function __get(string $name)
    {
        return $this->generator->{$name};
    }

    public function __call(string $name, array $arguments)
    {
        return $this->generator->{$name}(...$arguments);
    }

    /**
     * @throws FileNotFoundException
     */
    protected function getStub(): string
    {
        return Stub::getStub(path: $this->getStubPath());
    }
}
