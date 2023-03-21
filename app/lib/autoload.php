<?php
namespace PHPMVC\Lib;
class AutoLoad
{
    public static function autoload($className)
    {
        $className = strtolower(str_replace('PHPMVC', '', $className));
        $className = str_replace('/', '\\',$className);
        $className.='.php';
        if(file_exists(APP_PATH.$className)){
            require_once APP_PATH.$className;
        }
    }
}   
spl_autoload_register(__NAMESPACE__.'\AutoLoad::autoload');