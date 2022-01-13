<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/12
 * Time: 17:57
 */

namespace BlankPhp\Route\Traits;


use BlankPhp\Contract\RequestContract;
use BlankPhp\Facade;
use BlankPhp\Model\Model;
use BlankPhp\Request\Request;
use ReflectionFunctionAbstract;
use ReflectionMethod;
use ReflectionParameter;

trait ResolveSomeDepends
{

    /**
     * @throws \ReflectionException
     */
    public function resolveClassMethodDependencies($parameters, $instance, $method): array
    {
        //解决类方法的依赖-->反射解决
        if (!empty($parameters)){
            return $this->resolveMethodDependencies(
                $parameters, $instance !== 'Closure' ?
                new \ReflectionMethod($instance, $method) : new \ReflectionFunction($method)
            );
        }

        return $this->resolveMethodDependencies(
            $parameters, $instance !== 'Closure' ?
                new \ReflectionMethod($instance, $method) : new \ReflectionFunction($method)
        );

    }


    public function resolveMethodDependencies(array $parameters, ReflectionFunctionAbstract $reflector): array
    {
        $instanceCount = 0;
        $values = array_values($parameters);
        foreach ($reflector->getParameters() as $key => $parameter) {
            $instance = $parameter->getClass();
            if (!is_null($instance)) {
                array_splice($parameters, $key, $instanceCount,
                    [$this->app->make($instance->getName(),[$values[$instanceCount]])]
                );
            } elseif (!isset($values[$key - $instanceCount]) &&
                $parameter->isDefaultValueAvailable()) {
                array_splice($parameters, $key, $instanceCount, [$parameter->getDefaultValue()]);
                $instanceCount++;
            }
        }
        return $parameters;
    }


}