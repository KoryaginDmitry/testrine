<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Enums\Attributes;

use Dkdev\Testrine\Interfaces\FormatInterface;

enum NumberFormat: string implements FormatInterface
{
    case FLOAT = 'float';

    case NUMBER = 'number';
}
