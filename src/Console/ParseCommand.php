<?php

declare(strict_types=1);

namespace DkDev\Testrine\Console;

use DkDev\Testrine\EventHandlers\AfterDocGenerationEventHandler;
use DkDev\Testrine\EventHandlers\BeforeDocGenerationEventHandler;
use DkDev\Testrine\Parser\SwaggerParser;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;
use Throwable;

class ParseCommand extends Command
{
    protected $signature = 'testrine:parse';

    protected $description = 'Builds a json file from files in the data directory';

    /**
     * @throws Throwable
     */
    public function handle(SwaggerParser $generator): int
    {
        BeforeDocGenerationEventHandler::make()->handle();

        $generator->generate();

        AfterDocGenerationEventHandler::make()->handle();

        return CommandAlias::SUCCESS;
    }
}
