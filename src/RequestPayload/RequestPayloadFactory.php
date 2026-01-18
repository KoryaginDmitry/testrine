<?php

namespace DkDev\Testrine\RequestPayload;

use DkDev\Testrine\CodeBuilder\Builder;
use DkDev\Testrine\RequestPayload\Rules\BaseRule;
use DkDev\Testrine\RequestPayload\Traits\HasMimes;
use DkDev\Testrine\RequestPayload\Traits\HasRange;
use DkDev\Testrine\Testrine;
use DkDev\Testrine\Traits\Makeable;
use Illuminate\Routing\Route;
use Illuminate\Support\Str;

/**
 * @method static RequestPayloadFactory make(Route $route, array|string $rules, bool $valid = true)
 */
class RequestPayloadFactory
{
    use Makeable;

    public function __construct(
        protected Route $route,
        protected array|string $rules,
        protected bool $valid = true,
    ) {}

    public function generate(): string
    {
        $data = $this->generateFromTree(
            $this->buildRulesTree()
        );

        return Renderer::make()->render($data);
    }

    protected function buildRulesTree(): array
    {
        $tree = [];

        foreach ($this->rules as $key => $ruleSet) {
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

    protected function generateFromTree(array $tree): array
    {
        $result = [];

        foreach ($tree as $key => $value) {
            if (! isset($value['_rules'])) {
                $result[$key] = $this->generateFromTree($value);

                continue;
            }

            $value = $this->generateValue($key, $value['_rules']);

            if ($key === '*') {
                $result[] = $value;
            } else {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    protected function generateValue(string $key, array|string $rules): string
    {
        $rules = is_string($rules) ? explode('|', $rules) : $rules;

        $existsRules = collect();

        foreach (Testrine::rules()->list() as $rule) {
            /** @var BaseRule $rule */
            $rule = $rule::make(route: $this->route, key: $key, rules: $rules, valid: $this->valid);

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
        return str($key)->contains('id') ? 1 : Builder::make('')->staticCall(Str::class, 'random')->build();
    }
}
