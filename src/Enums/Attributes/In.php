<?php

declare(strict_types=1);

namespace DkDev\Testrine\Enums\Attributes;

enum In: string
{
    case BODY = 'body';

    case PATH = 'path';

    case QUERY = 'query';

    case RESPONSE = 'response';
}
