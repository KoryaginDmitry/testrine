<?php

declare(strict_types=1);

namespace DkDev\Testrine\Helpers;

class Char
{
    public const NL = "\n";

    public const TAB = "\t";

    public const NL2 = "\n\n";

    public const TAB3 = "\t\t\t";

    public const NL_TAB3 = "\n\t\t\t";

    public const NL2_TAB = "\n\n\t";

    public static function tabs(int $count): string
    {
        return str_repeat(self::TAB, $count);
    }

    public static function nls(int $count): string
    {
        return str_repeat(self::NL, $count);
    }
}
