<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Factories;

use Dkdev\Testrine\Enums\Writes\Format;
use Dkdev\Testrine\Readers\BaseReader;
use Dkdev\Testrine\Readers\JsonReader;

class ReaderFactory
{
    public static function make(Format $format): BaseReader
    {
        return match ($format) {
            Format::JSON => new JsonReader,
        };
    }
}
