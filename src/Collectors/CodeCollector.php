<?php

declare(strict_types=1);

namespace DkDev\Testrine\Collectors;

use DkDev\Testrine\Attributes\Code;

class CodeCollector extends Collector
{
    public function getName(): string
    {
        return 'code';
    }

    public function defaultHandler(): mixed
    {
        $code = $this->response->status();

        $attribute = $this->attributes
            ->filter(fn ($item) => $item instanceof Code
                && $item->code == $code
            )
            ->last();

        return [
            'code' => $code,
            'description' => $attribute?->description,
        ];
    }
}
