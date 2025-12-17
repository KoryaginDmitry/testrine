<?php

declare(strict_types=1);

namespace DkDev\Testrine\Mappers;

use DkDev\Testrine\Data\OpenApi\OpenApi;
use DkDev\Testrine\Data\OpenApi\Path\Path;

class PathMapper extends BaseMapper
{
    public function defaultHandler(): OpenApi
    {
        if (isset($this->data->paths[$this->fileData['path']])) {
            return $this->data;
        }

        $this->data->paths[$this->fileData['path']] = new Path;

        return $this->data;
    }
}
