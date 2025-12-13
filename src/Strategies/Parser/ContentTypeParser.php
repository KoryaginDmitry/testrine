<?php

declare(strict_types=1);

namespace DkDev\Testrine\Strategies\Parser;

use Illuminate\Support\Collection;
use Illuminate\Testing\TestResponse;

class ContentTypeParser extends BaseParserStrategy
{
    public function getName(): string
    {
        return 'content_type';
    }

    public function analyze(TestResponse $response, Collection $attributes): mixed
    {
        return [
            'response' => $response->headers->get('Content-Type'),
            'request' => request()->headers->get('Content-Type'),
        ];
    }
}
