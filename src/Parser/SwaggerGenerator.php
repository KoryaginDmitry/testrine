<?php

namespace DkDev\Testrine\Parser;

use DkDev\Testrine\Data\OpenApi\OpenApi;
use DkDev\Testrine\Enums\Writes\Format;
use DkDev\Testrine\Factories\DocFactory;
use DkDev\Testrine\Factories\ReaderFactory;
use DkDev\Testrine\Factories\WriterFactory;
use DkDev\Testrine\Helpers\Config;
use DkDev\Testrine\Helpers\StorageHelper;
use DkDev\Testrine\Strategies\Generators\BaseGeneratorStrategy;

class SwaggerGenerator
{
    public function generate(): void
    {
        $doc = DocFactory::build();

        $driver = StorageHelper::driver();

        foreach ($driver->files(Config::getSwaggerValue('storage.data.path')) as $file) {
            $doc = $this->parseFile($doc, $file);
        }

        $this->makeDocs($doc);
    }

    protected function parseFile(OpenApi $doc, string $path): OpenApi
    {
        /** @var BaseGeneratorStrategy $strategy */
        foreach (Config::getSwaggerValue('strategies.generators') as $strategy) {
            $doc = $strategy::make()->generate(
                data: $doc,
                fileData: ReaderFactory::make(Format::JSON)->read($path),
            );
        }

        return $doc;
    }

    protected function makeDocs(OpenApi $data): void
    {
        WriterFactory::make(Format::JSON)->write(
            path: Config::getSwaggerValue('storage.docs.path'),
            name: Config::getSwaggerValue('storage.docs.name'),
            data: (array) $data,
        );
    }
}
