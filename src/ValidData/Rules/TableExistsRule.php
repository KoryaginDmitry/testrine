<?php

declare(strict_types=1);

namespace Dkdev\Testrine\ValidData\Rules;

use Dkdev\Testrine\Enums\ValidData\RulePriority;

class TableExistsRule extends BaseRule
{
    protected string $table;

    protected string $key;

    public function getPriority(): RulePriority
    {
        return RulePriority::HIGH;
    }

    public function hasThisRule(): bool
    {
        foreach ($this->rules as $rule) {
            if (str((string) $rule)->contains('exists:')) {
                $ruleExists = str((string) $rule)->after('exists:')->explode(',')->toArray();

                $this->table = $ruleExists[0];
                $this->key = $ruleExists[1] && $ruleExists[1] !== 'NULL' ? $ruleExists[1] : $this->key;

                return true;
            }
        }

        return false;
    }

    public function getValue(): string
    {
        return "\Illuminate\Support\Facades\DB::table('$this->table')->select('$this->key')->limit(1)->value('$this->key')";
    }
}
