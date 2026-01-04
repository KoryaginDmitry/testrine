<?php

declare(strict_types=1);

namespace DkDev\Testrine\RequestPayload;

use DkDev\Testrine\Support\Char;
use DkDev\Testrine\Traits\Makeable;

class Renderer
{
    use Makeable;

    public function render(array $data): string
    {
        return $this->prepareData($data);
    }

    protected function prepareData(array $data, int $level = 0): string
    {
        $tabs = Char::NL_TAB3.str_repeat(Char::TAB, $level);
        $result = '';

        foreach ($data as $key => $value) {
            $result .= $this->formatValue($key, $value, $level);
        }

        return rtrim($result, $tabs);
    }

    protected function formatValue(mixed $key, mixed $value, int $level): string
    {
        $tabs = Char::NL_TAB3.str_repeat(Char::TAB, $level);

        if (is_array($value)) {
            $nextLevel = $level + 1;
            $content = $this->prepareData($value, $nextLevel);
            $prefix = $level > 0 ? Char::TAB : '';

            return "$prefix'$key' => [$tabs$content$tabs],$tabs";
        }

        $prefix = $level > 0 ? Char::TAB : '';

        return "$prefix$key => $value,$tabs";
    }
}
