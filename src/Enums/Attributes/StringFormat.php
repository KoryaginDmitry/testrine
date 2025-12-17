<?php

declare(strict_types=1);

namespace DkDev\Testrine\Enums\Attributes;

use DkDev\Testrine\Interfaces\FormatInterface;

enum StringFormat: string implements FormatInterface
{
    case DATE = 'date';

    case DATE_TIME = 'date-time';

    case EMAIL = 'email';

    case UUID = 'uuid';

    case BINARY = 'binary';

    case PASSWORD = 'password';

    case BYTE = 'byte';
}
