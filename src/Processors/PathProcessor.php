<?php

declare(strict_types=1);

namespace DkDev\Testrine\Processors;

use DkDev\Testrine\Doc\BaseDoc;
use DkDev\Testrine\Doc\OpenApi\Path\Path;

class PathProcessor extends BaseProcessor
{
    public function defaultHandler(): BaseDoc
    {
        if (isset($this->data->paths[$this->fileData['path']])) {
            return $this->data;
        }

        $this->data->paths[$this->fileData['path']] = new Path;

        return $this->data;
    }
}
