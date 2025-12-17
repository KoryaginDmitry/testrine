<?php

declare(strict_types=1);

namespace DkDev\Testrine\Mappers;

use DkDev\Testrine\Data\OpenApi\OpenApi;

class DescriptionMapper extends BaseMapper
{
    public function defaultHandler(): OpenApi
    {
        $this->data->paths[$this->fileData['path']]->methods[$this->fileData['method']]->description = $this->fileData['description'] ?? '';

        return $this->data;
    }
}
