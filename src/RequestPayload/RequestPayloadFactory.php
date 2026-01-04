<?php

namespace DkDev\Testrine\RequestPayload;

use DkDev\Testrine\RequestPayload\Rules\BaseRule;
use DkDev\Testrine\RequestPayload\Traits\HasMimes;
use DkDev\Testrine\RequestPayload\Traits\HasRange;
use DkDev\Testrine\Testrine;
use DkDev\Testrine\Traits\Makeable;
use Illuminate\Routing\Route;
use Illuminate\Support\Str;

class RequestPayloadFactory
{
    use Makeable;

    public function generate(Route $route, array|string $rules): string
    {
        $tree = $this->buildRulesTree($rules);

        $data = $this->generateFromTree($route, $tree);

        return Renderer::make()->render($data);
    }

    protected function buildRulesTree(array $rules): array
    {
        $tree = [];

        foreach ($rules as $key => $ruleSet) {
            $ruleSet = is_string($ruleSet)
                ? explode('|', $ruleSet)
                : $ruleSet;

            $segments = explode('.', $key);
            $node = &$tree;

            foreach ($segments as $segment) {
                if (! isset($node[$segment])) {
                    $node[$segment] = [];
                }
                $node = &$node[$segment];
            }

            if (! in_array('array', $ruleSet)) {
                $node['_rules'] = $ruleSet;
            }
        }

        return $tree;
    }

    protected function generateFromTree(Route $route, array $tree): array
    {
        $result = [];

        foreach ($tree as $key => $value) {
            if (! isset($value['_rules'])) {
                $result[$key] = $this->generateFromTree($route, $value);

                continue;
            }

            $value = $this->generateValue($route, $key, $value['_rules']);

            if ($key === '*') {
                $result[] = $value;
            } else {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    protected function generateValue(Route $route, string $key, array|string $rules): string
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
        return str($key)->contains('id') ? 1 : Str::random(12);
    }
}
