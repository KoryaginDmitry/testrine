<?php

declare(strict_types=1);

namespace DkDev\Testrine\Generators\Stubs\BaseClass;

use DkDev\Testrine\Generators\Stubs\BaseClassStub;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class AuthMethodsStub extends BaseClassStub
{
    public function getStubPath(): string
    {
        return 'base_class.test_from_auth_user';
    }

    public function getReplacementKey(): string
    {
        return '{{ test_from_auth_users }}';
    }

    /**
     * @throws FileNotFoundException
     */
    public function getReplacementValue(): string
    {
        foreach ($this->users as $user) {
            $this->pushResult(
                keys: ['{{ studly_name }}', '{{ name }}'],
                values: [str(string: $user)->studly(), $user],
            );
        }

        return $this->makeResult();
    }
}
