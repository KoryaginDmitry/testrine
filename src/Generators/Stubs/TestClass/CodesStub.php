<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Generators\Stubs\TestClass;

use Dkdev\Testrine\Contracts\CodeContract;
use Dkdev\Testrine\Generators\Stubs\TestClassStub;
use Dkdev\Testrine\Resolvers\Code\ValidDataCodeResolver;
use Dkdev\Testrine\Support\Char;
use Dkdev\Testrine\Support\Infrastructure\Route;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class CodesStub extends TestClassStub
{
    public function getStubPath(): string
    {
        return 'test.method_codes';
    }

    public function needUse(): bool
    {
        return in_array(needle: CodeContract::class, haystack: $this->contracts);
    }

    /**
     * @throws FileNotFoundException
     */
    public function getReplacementValue(): string
    {
        $result = collect($this->users)
            ->map(function (string $user, int $index) {
                $code = ValidDataCodeResolver::make(
                    route: Route::getRouteByName(routeName: $this->routeName),
                    group: $this->getGroup(),
                    userKey: $user
                )->handle();

                return $index === 0 ? "'$user' => $code" : Char::TAB3."'$user' => $code";
            })->implode(','.Char::NL);

        return $this->makeResult(key: '{{ default_codes }}', value: $result);
    }
}
