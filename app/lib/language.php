<?php
namespace PHPMVC\Lib;
class Language
{
    private $dictionary = [];
    
    public function load($path) {
        $defaultLanguage = APP_DEFAULT_LANGUAGE;
        if(isset($_SESSION['lang'])){
            $defaultLanguage = $_SESSION['lang'];
        }
        $languageFileToLoad = LANGUAGES_PATH.$defaultLanguage.DS. str_replace('&', DS,$path).'.lang.php';
        if(file_exists($languageFileToLoad)){
            require_once $languageFileToLoad;
            if(is_array($_)&&!empty($_)){
                foreach($_ as $key => $value){
                    $this->dictionary[$key] = $value;
                }
            }
        }else{
            trigger_error('The Language File '.$languageFileToLoad.' Does Not Exist',E_USER_WARNING);
        }
    }
    
    public function get($key)
    {
        if(array_key_exists($key, $this->dictionary)){
            return $this->dictionary[$key];
        }
    }
    
    public function feedKey($key,$data = [])
    {
        if(array_key_exists($key, $this->dictionary)){
            array_unshift($data, $this->dictionary[$key]);
            return call_user_func_array('sprintf', $data);
        }
    }
    public function getDictionary() 
    {
        return $this->dictionary;
    }
}