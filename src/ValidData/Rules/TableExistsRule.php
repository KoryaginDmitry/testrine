<?php

declare(strict_types=1);

namespace DkDev\Testrine\ValidData\Rules;

use DkDev\Testrine\CodeBuilder\Builder;
use DkDev\Testrine\Enums\ValidData\RulePriority;
use Illuminate\Support\Facades\DB;

class TableExistsRule extends BaseRule
{
    protected string $table;

    protected string $column;

    public function getPriority(): RulePriority
    {
        return RulePriority::HIGH;
    }

    public function hasThisRule(): bool
    {
        foreach ($this->rules as $rule) {
            if ($this->contains('exists:', $rule)) {
                $ruleExists = str((string) $rule)->after('exists:')->explode(',')->toArray();

                $this->table = $ruleExists[0];
                $this->column = $ruleExists[1] && $ruleExists[1] !== 'NULL' ? $ruleExists[1] : $this->key;

                return true;
            }
        }

        return false;
    }

    public function getValue(): string
    {
        return Builder::make('')
            ->staticCall(DB::class, 'table', $this->table)
            ->method('select', $this->column)
            ->method('limit', 1)
            ->method('value', $this->column)
            ->build();
    }
}
