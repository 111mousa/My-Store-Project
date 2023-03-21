<?php
namespace PHPMVC\Lib;

class Authentication
{
    private static $_instance;
    private $_session;
    private $_execludedRoutes = [
        '/MVCProject/public/index/default',
        '/MVCProject/public/auth/logout',
        '/MVCProject/public/users/profile',
        '/MVCProject/public/users/changepassword',
        '/MVCProject/public/users/settings',
        '/MVCProject/public/language/default',
        '/MVCProject/public/accessdenied/default',
        '/MVCProject/public/notfound/notfound',
        '/MVCProject/public/test/default'
    ];

    private function __construct($session)
    {
        $this->_session = $session;
    }

    private function __clone(){}
    
    public static function getInstance(SessionManager $session)
    {
        if(self::$_instance === null){
            self::$_instance = new self($session);
        }
        return self::$_instance;
    }

    public function isAuthorized()
    {
        return isset($this->_session->user);
    }
    
    public function hasAccess($controller,$action)
    {
        $url = '/MVCProject/public/'.$controller.'/'.$action;
        
        if(in_array($url, $this->_execludedRoutes) || in_array($url, $this->_session->user->Privileges)){
            return true;
        }
        return false;
    }
    
}