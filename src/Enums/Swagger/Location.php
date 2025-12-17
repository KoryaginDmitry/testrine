<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Enums\Swagger;

enum Location: string
{
    case PARAMETER = 'parameter';

    case RESPONSE = 'response';

    case BODY = 'body';
}
