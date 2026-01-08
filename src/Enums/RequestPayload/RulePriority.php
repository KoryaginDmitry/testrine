<?php

declare(strict_types=1);

namespace DkDev\Testrine\Enums\RequestPayload;

enum RulePriority: string
{
    case LOW = 'low';

    case MEDIUM = 'medium';

    case HIGH = 'high';

    case TOP = 'top';

    public function getNumberLevel(): int
    {
        return match ($this) {
            self::LOW => 1,
            self::MEDIUM => 5,
            self::HIGH => 10,
            self::TOP => 100,
        };
    }
}
