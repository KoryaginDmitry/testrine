<?php

declare(strict_types=1);

namespace DkDev\Testrine\Enums\Attributes;

use DkDev\Testrine\Interfaces\FormatInterface;

enum NumberFormat: string implements FormatInterface
{
    case FLOAT = 'float';

    case NUMBER = 'number';
}
