<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Enums\Attributes;

use Dkdev\Testrine\Interfaces\FormatInterface;

enum IntegerFormat: string implements FormatInterface
{
    case INT32 = 'int32';

    case INT64 = 'int64';
}
