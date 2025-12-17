<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Support;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;

class Stub
{
    /**
     * @throws FileNotFoundException
     */
    public static function getStub(string $path): string
    {
        $ds = DIRECTORY_SEPARATOR;
        $stub = str($path)->replace(search: '.', replace: $ds);

        return File::get(
            path: __DIR__."$ds..$ds..{$ds}stubs$ds$stub.stub"
        );
    }
}
