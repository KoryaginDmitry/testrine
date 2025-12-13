<?php

declare(strict_types=1);

namespace DkDev\Testrine\Console;

use DkDev\Testrine\Helpers\Config;
use DkDev\Testrine\Helpers\StorageHelper;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class DestroyDataCommand extends Command
{
    protected $signature = 'testrine:destroy';

    protected $description = 'Cleans up the temporary files directory';

    public function handle(): int
    {
        StorageHelper::driver()->deleteDirectory(Config::getSwaggerValue('storage.data.path'));

        return CommandAlias::SUCCESS;
    }
}
