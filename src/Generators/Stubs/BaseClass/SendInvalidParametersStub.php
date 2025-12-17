<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Generators\Stubs\BaseClass;

use Dkdev\Testrine\Generators\Stubs\BaseClassStub;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class SendInvalidParametersStub extends BaseClassStub
{
    public function getStubPath(): string
    {
        return 'base_class.send_invalid_parameters';
    }

    public function getReplacementKey(): string
    {
        return '{{ send_invalid_parameters }}';
    }

    /**
     * @throws FileNotFoundException
     */
    public function getReplacementValue(): string
    {
        foreach ($this->users as $user) {
            $this->pushResult(
                keys: ['{{ studly_name }}', '{{ name }}'],
                values: [str($user)->studly(), $user]
            );
        }

        return $this->makeResult();
    }
}
