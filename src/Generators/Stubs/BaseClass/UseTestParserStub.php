<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Generators\Stubs\BaseClass;

use Dkdev\Testrine\Generators\Stubs\BaseClassStub;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class UseTestParserStub extends BaseClassStub
{
    public function getStubPath(): string
    {
        return 'base_class.use_test_parser';
    }

    public function getReplacementKey(): string
    {
        return '{{ use_test_parser }}';
    }

    /**
     * @throws FileNotFoundException
     */
    public function getReplacementValue(): string
    {
        return $this->getStub();
    }
}
