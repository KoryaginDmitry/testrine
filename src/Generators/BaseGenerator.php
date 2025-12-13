<?php

namespace DkDev\Testrine\Generators;

use DkDev\Testrine\Generators\Stubs\BaseStub;
use DkDev\Testrine\Helpers\Config;

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
