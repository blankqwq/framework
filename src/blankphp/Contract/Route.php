<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/10
 * Time: 21:33
 */

namespace Blankphp\Contract;


use Blankphp\Application;
use Blankphp\Route\RuleCollection;

interface Route
{
    public function __construct(Application $app,RuleCollection $collection);

}