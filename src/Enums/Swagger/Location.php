<?php

declare(strict_types=1);

namespace DkDev\Testrine\Enums\Swagger;

enum Location: string
{
    case PARAMETER = 'parameter';

    case RESPONSE = 'response';

    case BODY = 'body';
}
