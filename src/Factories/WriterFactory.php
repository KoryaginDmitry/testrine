<?php

declare(strict_types=1);

namespace DkDev\Testrine\Factories;

use DkDev\Testrine\Enums\Writes\Format;
use DkDev\Testrine\Writers\BaseWriter;
use DkDev\Testrine\Writers\JsonWriter;

class WriterFactory
{
    public static function make(Format $type): BaseWriter
    {
        return match ($type) {
            Format::JSON => new JsonWriter,
        };
    }
}
