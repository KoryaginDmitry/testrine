<?php

declare(strict_types=1);

namespace DkDev\Testrine\Factories;

use DkDev\Testrine\Enums\Writes\Format;
use DkDev\Testrine\Readers\BaseReader;
use DkDev\Testrine\Readers\JsonReader;

class ReaderFactory
{
    public static function make(Format $format): BaseReader
    {
        return match ($format) {
            Format::JSON => new JsonReader,
        };
    }
}
