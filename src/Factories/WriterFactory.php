<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Factories;

use Dkdev\Testrine\Enums\Writes\Format;
use Dkdev\Testrine\Writers\BaseWriter;
use Dkdev\Testrine\Writers\JsonWriter;

class WriterFactory
{
    public static function make(Format $type): BaseWriter
    {
        return match ($type) {
            Format::JSON => new JsonWriter,
        };
    }
}
