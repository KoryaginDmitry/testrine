<?php

declare(strict_types=1);

namespace DkDev\Testrine\Console;

use DkDev\Testrine\Handlers\AfterTestHandler;
use DkDev\Testrine\Handlers\BeforeTestsHandler;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Command\Command as CommandAlias;

class GenerateCommand extends Command
{
    protected $signature = 'testrine:generate';

    protected $description = 'Clears the data directory, runs tests, and generates a new yaml file for swagger';

    public function handle(): int
    {
        Artisan::call('testrine:destroy');

        BeforeTestsHandler::make()->handle();

        Artisan::call('test');

        AfterTestHandler::make()->handle();

        Artisan::call('testrine:parse');

        Artisan::call('testrine:destroy');

        return CommandAlias::SUCCESS;
    }
}
