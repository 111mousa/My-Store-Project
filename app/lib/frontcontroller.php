<?php

namespace PHPMVC\Lib;

use PHPMVC\Lib\Template\Template;
use PHPMVC\Lib\Helper;

class FrontController
{
    use Helper;
    
    const NOT_FOUND_ACTION = 'notFoundAction';
    const NOT_FOUND_CONTROLLER = 'PHPMVC\Controllers\NotFoundController';

    private $_controller = 'index';
    private $_action = 'default';
    private $_template;
    private $_registry;
    private $_authentication;
    private $_params = array();

    public function __construct(Template $template, Registry $registry, Authentication $auth)
    {
        $this->_template = $template;
        $this->_authentication = $auth;
        $this->_registry = $registry;
        $this->__parseUrl();
    }
    private function __parseUrl()
    {
        $url = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
        if (isset($url[2]) && $url[2] != '') {
            $this->_controller = $url[2];
        }
        if (isset($url[3]) && $url[3] != '') {
            $this->_action = $url[3];
        }
        if (isset($url[4]) && $url[4] != '') {
            $this->_params = explode('/', $url[4]);
        }
    }

    public function dispatch()
    {
        $controllerClassName =  'PHPMVC\Controllers\\' . ucfirst($this->_controller) . 'Controller';
        $actionName = $this->_action . 'Action';
        // Check If The User Is Authorized To Access The Application
        if (!$this->_authentication->isAuthorized()) {
            if($this->_controller !== 'auth' && $this->_action !== 'login'){
                $this->redirect('/MVCProject/public/auth/login');
            }
        }else{
            if($this->_controller == 'auth' && $this->_action == 'login'){
                isset($_SERVER['HTTP_REFERER']) ? $this->redirect($_SERVER['HTTP_REFERER']) : $this->redirect('/MVCProject/public/');
            }
            if(CHECK_FOR_PRIVILEGES){
                if(!$this->_authentication->hasAccess($this->_controller, $this->_action)){
                    $this->redirect('/MVCProject/public/accessdenied/default');
                }
            }
            
        }
        if (!class_exists($controllerClassName) || !method_exists($controllerClassName, $actionName)) {
            $controllerClassName = self::NOT_FOUND_CONTROLLER;
            $this->_action = $actionName = self::NOT_FOUND_ACTION;
        }
        $controller = new $controllerClassName();
        $controller->set_controller($this->_controller);
        $controller->set_action($this->_action);
        $controller->set_params($this->_params);
        $controller->setTemplate($this->_template);
        $controller->setRegistry($this->_registry);
        $controller->$actionName();
    }
}