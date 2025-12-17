<?php

namespace Dkdev\Testrine\Console;

use Dkdev\Testrine\Generators\BaseClassGenerator;
use Dkdev\Testrine\Inform\Inform;
use Dkdev\Testrine\Support\Infrastructure\Config;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class InitCommand extends Command
{
    protected $signature = 'testrine:init';

    protected $description = 'Creates base classes based on the config';

    /**
     * @throws FileNotFoundException
     */
    public function handle(): int
    {
        foreach (Config::getGroups() as $group) {
            BaseClassGenerator::make(group: $group)->generate();
        }

        $this->info(__('testrine::console.init.success'));

        Inform::print($this);

        return self::SUCCESS;
    }
}
