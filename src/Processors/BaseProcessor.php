<?php

declare(strict_types=1);

namespace DkDev\Testrine\Processors;

use DkDev\Testrine\Doc\BaseDoc;
use DkDev\Testrine\Traits\HasHandler;
use DkDev\Testrine\Traits\Makeable;

/**
 * @method static BaseProcessor make(BaseDoc $data, array $fileData)
 */
abstract class BaseProcessor
{
    use HasHandler;
    use Makeable;

    public function __construct(
        protected BaseDoc $data,
        protected array $fileData
    ) {}
}
