<?php
/**
 * Created by PhpStorm.
 * User: zhangcheng
 * Date: 2017/1/26
 * Time: 下午7:54
 */

error_reporting(E_ALL | E_STRICT);

// register silently failing autoloader
spl_autoload_register(function($class)
{
    if (0 === strpos($class, 'FreeStory\\Story\\')) {
        $path = __DIR__.'/../src/'.strtr($class, '\\', '/').'.php';
        if (is_file($path) && is_readable($path)) {
            require_once $path;

            return true;
        }
    } else if(0 === strpos($class, 'FreeStory\\') ){
        $path = __DIR__.'/../src/'.strtr($class, '\\', '/').'.php';
        if (is_file($path) && is_readable($path)) {
            require_once $path;

            return true;
        }
    }
});