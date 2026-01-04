<?php

declare(strict_types=1);

namespace DkDev\Testrine\RequestPayload\Rules;

use DkDev\Testrine\CodeBuilder\Builder;
use DkDev\Testrine\Enums\ValidData\RulePriority;
use DkDev\Testrine\RequestPayload\Traits\HasMimes;
use DkDev\Testrine\RequestPayload\Traits\HasRange;
use Illuminate\Http\UploadedFile;

class FileRule extends BaseRule
{
    use HasMimes;
    use HasRange;

    public function getPriority(): RulePriority
    {
        return RulePriority::MEDIUM;
    }

    public function hasThisRule(): bool
    {
        return $this->inRules('file');
    }

    public function getValue(): string
    {
        $mime = ! empty($this->mimes) ? $this->mimes[0] : null;
        $size = fake()->numberBetween(1, $this->max ?: 1000);

        return Builder::make('')
            ->staticCall(UploadedFile::class, 'fake')
            ->method('create', 'test', $size, $mime)
            ->build();
    }

    public function getInvalidValue(): string
    {
        return $this->randomStr();
    }
}
