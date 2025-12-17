<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Generators\Stubs\BaseClass;

use Dkdev\Testrine\Generators\Stubs\BaseClassStub;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class SendNotValidDataStub extends BaseClassStub
{
    public function getStubPath(): string
    {
        return 'base_class.send_not_valid_data';
    }

    public function getReplacementKey(): string
    {
        return '{{ send_not_valid_data }}';
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
