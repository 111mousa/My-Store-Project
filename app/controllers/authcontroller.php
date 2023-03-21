<?php
namespace PHPMVC\Controllers;
use PHPMVC\Lib\Messenger;
use PHPMVC\Models\UserModel;
use PHPMVC\Lib\Helper;

class AuthController extends AbstractController
{
    use Helper;
    
    public function loginAction()
    {
        $this->language->load('auth&login');
        $this->_template->swapeTemplate(
            [
                ':view'     =>  ':action_view'
            ]
        );

        if(isset($_POST['login']))
        {
            $isAuthorized = UserModel::authenticate($_POST['ucname'],$_POST['ucpwd'],$this->session);
            if($isAuthorized === 2){
                $this->messenger->add($this->language->get('text_user_disabled'),Messenger::APP_MESSAGE_ERROR);
            }elseif($isAuthorized === 1){
                $this->redirect('/MVCProject/public/');
            }elseif ($isAuthorized === false) {
                $this->messenger->add($this->language->get('text_user_not_found'),Messenger::APP_MESSAGE_ERROR);
            }
        }

        $this->_view();
    }
    
    public function logoutAction()
    {
        $this->session->kill();
        $this->redirect('/MVCProject/public/auth/login');
    }
    
}