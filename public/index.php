<?php

use PHPMVC\Lib\Authentication;
use PHPMVC\Lib\FrontController;
use PHPMVC\Lib\Template\Template;
use PHPMVC\Lib\Language;
use PHPMVC\Lib\SessionManager;
use PHPMVC\Lib\Registry;
use PHPMVC\Lib\Messenger;

require_once '..'.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';
require_once '..'.DS.'app'.DS.'lib'.DS.'autoload.php';

$session = new SessionManager();
$session->start();

if(!isset($session->lang)){
    $session->lang = APP_DEFAULT_LANGUAGE;
}
$template_patrs = require_once '..'.DS.'app'.DS.'config'.DS.'templateconfig.php';
$template = new Template($template_patrs);

$language = new Language();
$messenger = Messenger::getInstance($session);
$authentication = Authentication::getInstance($session);
$registery = Registry::getInstance();
$registery->session = $session;
$registery->language = $language;
$registery->messenger = $messenger;
$frontController = new FrontController($template,$registery,$authentication);
$frontController->dispatch();