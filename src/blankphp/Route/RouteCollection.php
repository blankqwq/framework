<?php

/*
 * This file is part of the /blankphp/framework.
 *
 * (c) 沉迷 <1136589038@qq.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace BlankPhp\Route;

use BlankPhp\Collection\Collection;

class RouteCollection extends Collection
{
    /**
     * @var array
     */
    private $rules = [];

    private function insert($url, $method, $rule)
    {
        $this->item[$url][$method] = $rule;
    }

    private function addRules($rule)
    {
        $this->rules[] = $rule;
    }

    private function parseRules()
    {
        /** @var RouteRule $rule */
        foreach ($this->rules as $rule) {
            $this->insert($rule->getUrl(), $rule->getMethod(), $rule);
        }
        $this->rules = [];
    }

    public function pregUri($uri)
    {
        $this->parseRules();
        foreach ($this->item as $k => $v) {
            if (preg_match("#^$k$#", $uri, $match)) {
                return $v;
            }
        }
    }

    public function items(): array
    {
        $this->parseRules();

        return parent::items(); // TODO: Change the autogenerated stub
    }

    public function __toArray(): array
    {
        $this->parseRules();

        return $this->item;
    }

    public function add(RouteRule $routeRule): RouteRule
    {
        $this->addRules($routeRule);

        return $routeRule;
    }
}
