<?php

declare(strict_types=1);

namespace DkDev\Testrine\Mappers;

use DkDev\Testrine\Data\OpenApi\OpenApi;
use DkDev\Testrine\Traits\HasHandler;
use DkDev\Testrine\Traits\Makeable;

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
