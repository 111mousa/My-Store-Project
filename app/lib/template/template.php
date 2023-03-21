<?php
namespace PHPMVC\Lib\Template;
class Template
{
    use TemplateHelper;
    
    private $_templateParts;
    private $_action_view;
    private $_data;
    private $_registry;
    
    public function __construct(array $parts) {
        $this->_templateParts = $parts;
    }
    
    public function __get($key) {
        return $this->_registry->$key;
    }
    
    public function swapeTemplate($template)
    {
        $this->_templateParts['template'] = $template;
    }

    public function setActionViewPath($actionViewPath)
    {
        $this->_action_view = $actionViewPath;
    }
    
    public function setRegistry($registry)
    {
        $this->_registry = $registry;
    }
    
    public function setAppData($data) {
        $this->_data = $data;
    }
    
    private function renderTemplateHeaderStart()
    {
        extract($this->_data);
        require_once TEMPLATE_PATH.'templateheaderstart.php';
    }
    
    private function renderTemplateHeaderEnd()
    {
        extract($this->_data);
        require_once TEMPLATE_PATH.'templateheaderend.php';
    }
    
    private function renderTemplateFooter()
    {
        extract($this->_data);
        require_once TEMPLATE_PATH.'templatefooter.php';
    }
    
    private function renderHeaderResources() {
        $output = '';
        if(array_key_exists('header_resources', $this->_templateParts)){
            $resources = $this->_templateParts['header_resources'];
            //Generate CSS Links
            $css = $resources['css'];
            if(!empty($css)){
                foreach ($css as $cssKey => $path){
                    $output.='<link type="text/css" rel="stylesheet" href="'.$path.'" />';
                }
            }
        //Generate JS Scripts
            $js = $resources['js'];
            if(!empty($js)){
                foreach ($js as $jsKey => $path){
                    $output.='<script src="'.$path.'" ></script>';
                }
            }
        }else{
            trigger_error('Sorry You Have To Define The Header Resources',E_USER_WARNING);
        }
        echo $output;
    }
    private function renderTemplateBlocks()
    {
        if(array_key_exists('template', $this->_templateParts)){
            $parts = $this->_templateParts['template'];
            if(!empty($parts)){
                extract($this->_data);
                foreach ($parts as $partKey => $file){
                    if($partKey === ':view'){
                        require_once $this->_action_view;
                    }else{
                        require_once $file;
                    }
                }
            }
        }else{
            trigger_error('Sorry You Have To Define The Template Blocks',E_USER_WARNING);
        }
    }
    
    public function renderFooterResources()
    {
        $output = '';
        if(array_key_exists('header_resources', $this->_templateParts)){
            $resources = $this->_templateParts['footer_resources'];
                if(!empty($resources)){
                    foreach ($resources as $resourceKey => $path){
                        $output.='<script src="'.$path.'" ></script>';
                    }
                }
        }else{
            trigger_error('Sorry You Have To Define The Header Resources',E_USER_WARNING);
        }
        echo $output;
    }
    public function renderApp()
    {
        $this->renderTemplateHeaderStart();
        $this->renderHeaderResources();
        $this->renderTemplateHeaderEnd();
        $this->renderTemplateBlocks();
        $this->renderFooterResources();
        $this->renderTemplateFooter();
    }
}