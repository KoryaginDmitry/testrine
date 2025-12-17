<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Enums\Attributes;

enum Type: string
{
    case STRING = 'string';

    case INTEGER = 'integer';

    case NUMBER = 'number';

    case ENUM = 'enum';

    case ARRAY = 'array';

    case OBJECT = 'object';

    case BOOL = 'boolean';
}
