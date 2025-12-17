<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Data\OpenApi\Path\Method;

use Dkdev\Testrine\Data\OpenApi\Path\Method\Body\RequestBody;
use Dkdev\Testrine\Data\OpenApi\Path\Method\Parameter\Parameter;
use Dkdev\Testrine\Data\OpenApi\Path\Method\Response\Code;
use JsonSerializable;

class Method implements JsonSerializable
{
    /**
     * @param  array<int, Code>  $responses
     * @param  Parameter[]  $parameters
     */
    public function __construct(
        public array $tags = [],
        public string $summary = '',
        public string $description = '',
        public ?array $security = null,
        public array $responses = [],
        public ?RequestBody $requestBody = null,
        public array $parameters = [],
    ) {}

    public function jsonSerialize(): mixed
    {
        return array_filter([
            'tags' => ! empty($this->tags) ? $this->tags : null,
            'summary' => ! empty($this->summary) ? $this->summary : null,
            'description' => ! empty($this->description) ? $this->description : null,
            'security' => ! empty($this->security) ? $this->security : null,
            'responses' => $this->responses,
            'requestBody' => $this->requestBody,
            'parameters' => ! empty($this->parameters) ? $this->parameters : null,
        ]);
    }
}
