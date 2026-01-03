<?php

declare(strict_types=1);

namespace DkDev\Testrine\Support\Infrastructure;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Filesystem\LocalFilesystemAdapter;
use Illuminate\Support\Facades\Storage;

class StorageHelper
{
    public static function driver(): Filesystem|LocalFilesystemAdapter
    {
        return Storage::drive(
            Config::getDocsValue('storage.driver')
        );
    }
}
