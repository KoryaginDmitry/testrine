<?php

declare(strict_types=1);

namespace DkDev\Testrine\Doc\OpenApi;

use DkDev\Testrine\Doc\BaseDoc;
use DkDev\Testrine\Doc\OpenApi\Info\Info;
use DkDev\Testrine\Doc\OpenApi\Path\Path;
use DkDev\Testrine\Doc\OpenApi\Server\Server;

class OpenApi extends BaseDoc
{
    /**
     * @param  Server[]  $servers
     * @param  array<string, Path>  $paths
     */
    public function __construct(
        public string $openapi,
        public Info $info,
        public array $servers,
        public array $paths,
        public array $components,
    ) {}

    public static function fromArray(array $data): static
    {
        return new self(
            openapi: $data['openapi'],
            info: Info::fromArray($data['info']),
            servers: array_map(fn (array $server) => Server::fromArray($server), $data['servers']),
            paths: $data['paths'],
            components: $data['components'],
        );
    }
}
