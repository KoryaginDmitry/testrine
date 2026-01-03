<?php

declare(strict_types=1);

namespace DkDev\Testrine\Console;

use DkDev\Testrine\Handlers\AfterDocGenerationHandler;
use DkDev\Testrine\Handlers\BeforeDocGenerationHandler;
use DkDev\Testrine\Parser\SwaggerGenerator;
use Illuminate\Console\Command;
use JsonException;
use Symfony\Component\Console\Command\Command as CommandAlias;
use Throwable;

class ParseCommand extends Command
{
    protected $signature = 'testrine:parse';

    protected $description = 'Builds a json file from files in the data directory';

    /**
     * @throws Throwable
     * @throws JsonException
     */
    public function handle(SwaggerGenerator $generator): int
    {
        BeforeDocGenerationHandler::make()->handle();

        $generator->generate();

        AfterDocGenerationHandler::make()->handle();

        return CommandAlias::SUCCESS;
    }
}
