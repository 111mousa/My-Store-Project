<?php
namespace PHPMVC\Lib;
trait Helper
{
    public function redirect($path)
    {
        session_write_close();
        header('Location: ' . $path);
        exit();
    }
    
}