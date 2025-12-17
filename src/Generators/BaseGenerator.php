<?php

namespace Dkdev\Testrine\Generators;

use Dkdev\Testrine\Generators\Stubs\BaseStub;
use Dkdev\Testrine\Support\Infrastructure\Config;

abstract class BaseGenerator
{
    public array $users;

    protected array $stubs;

    public function __construct()
    {
        $this->users = Config::getGroupValue(group: $this->getGroup(), key: 'users');

        foreach ($this->getStubs() as $stub) {
            $this->stubs[] = $stub::make($this);
        }
    }

    /**
     * @return array<BaseStub>
     */
    abstract public function getStubs(): array;

    abstract public function getGroup(): string;

    public function getStudlyGroup(): string
    {
        return str($this->getGroup())->studly();
    }
}
