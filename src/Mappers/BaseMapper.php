<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Mappers;

use Dkdev\Testrine\Data\OpenApi\OpenApi;
use Dkdev\Testrine\Traits\HasHandler;
use Dkdev\Testrine\Traits\Makeable;

/**
 * @method static BaseMapper make(OpenApi $data, array $fileData)
 */
abstract class BaseMapper
{
    use HasHandler;
    use Makeable;

    public function __construct(
        protected OpenApi $data,
        protected array $fileData
    ) {}
}
