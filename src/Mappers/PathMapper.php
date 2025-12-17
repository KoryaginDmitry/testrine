<?php

declare(strict_types=1);

namespace Dkdev\Testrine\Mappers;

use Dkdev\Testrine\Data\OpenApi\Path\Path;

class PathMapper extends BaseMapper
{
    public function defaultHandler(): mixed
    {
        if (isset($data->paths[$this->fileData['path']])) {
            return $data;
        }

        $this->data->paths[$this->fileData['path']] = new Path;

        return $this->data;
    }
}
