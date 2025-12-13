<?php

declare(strict_types=1);

namespace DkDev\Testrine\Strategies\Parser;

use DkDev\Testrine\Attributes\Code;
use Illuminate\Support\Collection;
use Illuminate\Testing\TestResponse;

class CodeStrategy extends BaseParserStrategy
{
    public function getName(): string
    {
        return 'code';
    }

    public function analyze(TestResponse $response, Collection $attributes): mixed
    {
        $code = $response->status();

        $attribute = $attributes
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
