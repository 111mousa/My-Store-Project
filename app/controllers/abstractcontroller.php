<?php
namespace PHPMVC\Controllers;
use PHPMVC\Lib\Template\Template;
use PHPMVC\Lib\FrontController;
use PHPMVC\Lib\Registry;
use PHPMVC\Lib\Validate;

class AbstractController
{
    use Validate;
    
    protected $_controller ;
    protected $_action ;
    protected $_params;
    protected $_template;
    protected $_registry;
    protected $_data = array();
    
    public function notFoundAction()
    {
        $this->_view();
    }
    
    public function __get($key)
    {
        return $this->_registry->$key;
    }
    
    public function set_controller($_controller): void {
        $this->_controller = $_controller;
    }

    public function setTemplate(Template $template){
        $this->_template = $template;
    }
    
    public function setRegistry(Registry $registry){
        $this->_registry = $registry;
    }
    
    public function set_action($_action): void {
        $this->_action = $_action;
    }

    public function set_params($_params): void {
        $this->_params = $_params;
    }
    
    protected function _view()
    {
        $view = VIEWS_PATH.$this->_controller.DS.$this->_action.'.view.php';
        if($this->_action == FrontController::NOT_FOUND_ACTION || !file_exists($view))
        {
            $view = VIEWS_PATH.'notfound'.DS.'notfound.view.php';
        }
                $this->_data = array_merge($this->_data,$this->language->getDictionary());
                $this->_template->setRegistry($this->_registry);
                $this->_template->setActionViewPath($view);
                $this->_template->setAppData($this->_data);
                $this->_template->renderApp();
    }
    
}