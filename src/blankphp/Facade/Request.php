<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/11
 * Time: 13:31
 */

namespace BlankPhp\Facade;

use BlankPhp\Facade;

class Request extends Facade
{
    protected static function getFacadeAccessor()
    {
        //门面模式
        return 'request';
    }

}