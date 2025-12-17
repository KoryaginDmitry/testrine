<?php

declare(strict_types=1);

namespace Dkdev\Testrine\ValidData\Rules;

use Dkdev\Testrine\Enums\ValidData\RulePriority;
use Dkdev\Testrine\ValidData\Traits\HasMimes;
use Dkdev\Testrine\ValidData\Traits\HasRange;

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
        return in_array('file', $this->rules, true);
    }

    public function getValue(): string
    {
        $mime = ! empty($this->mimes) ? $this->mimes[0] : null;
        $size = fake()->numberBetween(1, $this->max ?: 1000);

        return "\Illuminate\Http\UploadedFile::fake()->create('test', $size, $mime)";
    }
}
