<?php

declare(strict_types=1);

namespace DkDev\Testrine\Generators\Stubs\BaseClass;

use DkDev\Testrine\Generators\Stubs\BaseClassStub;
use DkDev\Testrine\Support\Infrastructure\Config;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class RouteStub extends BaseClassStub
{
    public function getStubPath(): string
    {
        return 'base_class.route_action';
    }

    public function getReplacementKey(): string
    {
        return '{{ route_actions }}';
    }

    /**
     * @throws FileNotFoundException
     */
    public function getReplacementValue(): string
    {
        foreach ($this->users as $user) {
            $this->pushResult(
                keys: ['{{ name }}', '{{ user_key }}', '{{ auth }}'],
                values: [str($user)->studly(), $user, Config::getGroupValue(group: $this->getGroup(), key: "auth.$user")],
            );
        }

        return $this->makeResult();
    }
}
