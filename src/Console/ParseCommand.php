<?php

declare(strict_types=1);

namespace DkDev\Testrine\Console;

use DkDev\Testrine\Parser\SwaggerGenerator;
use Illuminate\Console\Command;
use JsonException;
use Symfony\Component\Console\Command\Command as CommandAlias;
use Throwable;

class ParseCommand extends Command
{
    protected $signature = 'testrine:parse';

    protected $description = 'Builds a YAML file from files in the data directory';

    /**
     * @throws Throwable
     * @throws JsonException
     */
    public function handle(SwaggerGenerator $generator): int
    {
        $generator->generate();

        return CommandAlias::SUCCESS;
    }
}
