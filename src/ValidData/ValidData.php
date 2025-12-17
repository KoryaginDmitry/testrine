<?php

namespace DkDev\Testrine\ValidData;

use DkDev\Testrine\Testrine;
use DkDev\Testrine\Traits\Makeable;
use DkDev\Testrine\ValidData\Rules\BaseRule;
use DkDev\Testrine\ValidData\Traits\HasMimes;
use DkDev\Testrine\ValidData\Traits\HasRange;
use Illuminate\Routing\Route;

class ValidData
{
    use Makeable;

    public function generate(Route $route, string $key, array|string $rules): string
    {
        $rules = is_string($rules) ? explode('|', $rules) : $rules;

        $existsRules = collect();

        foreach (Testrine::rules()->list() as $rule) {
            /** @var BaseRule $rule */
            $rule = $rule::make(route: $route, key: $key, rules: $rules);

            if ($rule->hasThisRule()) {
                if (in_array(HasRange::class, class_uses($rule))) {
                    call_user_func([$rule, 'setRange'], $rules);
                }

                if (in_array(HasMimes::class, class_uses($rule))) {
                    call_user_func([$rule, 'setMimes'], $rules);
                }

                $existsRules->push($rule);
            }
        }

        /** @var BaseRule $headRule */
        $headRule = $existsRules->sortByDesc(function (BaseRule $rule) {
            return $rule->getPriority()->getNumberLevel();
        })->first();

        return $headRule ? $headRule->makeResult() : $this->makeStub($key);
    }

    protected function makeStub(string $key): string
    {
        return "'$key' => str('$key')->contains('id') ? 1 : \Illuminate\Support\Str::random(12),\n\t\t\t";
    }
}
