<?php

declare(strict_types=1);

namespace DkDev\Testrine\Enums\Inform;

enum Level: string
{
    case INFO = 'info';

    case WARNING = 'warning';

    case ERROR = 'error';
}
