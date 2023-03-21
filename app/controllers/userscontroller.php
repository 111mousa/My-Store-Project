<?php
namespace PHPMVC\Controllers;
use PHPMVC\Models\UserModel;
use PHPMVC\Models\UserGroupModel;
use PHPMVC\Lib\InputFilter;
use PHPMVC\Lib\Helper;
use PHPMVC\Lib\Messenger;
use PHPMVC\Models\UserProfileModel;

class UsersController extends AbstractController
{
    use InputFilter;
    use Helper;
    
    private $_createActionRoles = 
    [
        'FirstName'      => 'req|alpha|between(3,10)',
        'LastName'      => 'req|alpha|between(3,10)',
        'UserName'      => 'req|alphanum|between(3,12)',
        'Password'      => 'req|max(8)|eqField(CPassword)',
        'CPassword'     => 'req|max(8)',
        'Email'         => 'req|email|eqField(CEmail)',
        'CEmail'        => 'req|email',
        'PhoneNumber'   => 'alphanum|max(15)' ,
        'GroupId'       => 'req|int'
    ];

    private $_editActionRoles = 
    [
        'PhoneNumber'   => 'alphanum|max(15)' ,
        'GroupId'       => 'req|int'
    ];

    public function defaultAction()
    {
        $this->language->load('template&common');
        $this->language->load('users&default');
        $this->_data['users'] = UserModel::getUsers($this->session->user);
        $this->_view();
    }
    
    public function createAction() {
        $this->language->load('template&common');
        $this->language->load('users&create');
        $this->language->load('users&labels');
        $this->language->load('validation&errors');
        $this->language->load('users&messages');
        
        $this->_data['groups'] = UserGroupModel::getAll();
        if(isset($_POST['submit'])&&$this->isValid($this->_createActionRoles, $_POST))
        {
            $user = new UserModel();
            $user->UserName = $this->filterString($_POST['UserName']);
            $user->cryptPassword($_POST['Password']);
            $user->Email = $this->filterString($_POST['Email']);
            $user->PhoneNumber = $this->filterString($_POST['PhoneNumber']);
            $user->GroupId = $this->filterInt($_POST['GroupId']);
            $user->SubscribtionDate = date('Y-m-d');
            $user->LastLogin = date('Y-m-d H:i:s');
            $user->Status = 1;
            if(UserModel::userExist($user->UserName))
            {
                $this->messenger->add($this->language->get('message_user_exist'), Messenger::APP_MESSAGE_ERROR);
                $this->redirect('/MVCProject/public/users');
            }
            
            if($user->save()){
                $userProfile = new UserProfileModel();
                $userProfile->FirstName = $this->filterString($_POST['FirstName']);
                $userProfile->LastName = $this->filterString($_POST['LastName']);
                $userProfile->UserId = $user->UserId;
                $userProfile->save(false);
                $this->messenger->add($this->language->get('message_create_success'));
            }else{
                $this->messenger->add($this->language->get('message_create_failed'), Messenger::APP_MESSAGE_ERROR);
            }
            $this->redirect('/MVCProject/public/users');
        }
        $this->_view();
    }

    public function editAction() {
        $id = $this->filterInt($this->_params[0]);
        $user = UserModel::getByPK($id);
        if($user === false || $this->session->user->UserId === $id){
            $this->redirect('/MVCProject/public/users');
        }
        $this->_data['user'] = $user;
        $this->_data['groups'] = UserGroupModel::getAll();
        $this->language->load('template&common');
        $this->language->load('users&edit');
        $this->language->load('users&labels');
        $this->language->load('validation&errors');
        $this->language->load('users&messages');

        if(isset($_POST['submit'])&&$this->isValid($this->_editActionRoles, $_POST))
        {
            $user->PhoneNumber = $this->filterString($_POST['PhoneNumber']);
            $user->GroupId = $this->filterInt($_POST['GroupId']);
            if($user->save()){
                $this->messenger->add($this->language->get('message_create_success'));
            }else{
                $this->messenger->add($this->language->get('message_create_failed'), Messenger::APP_MESSAGE_ERROR);
            }
            $this->redirect('/MVCProject/public/users');
        }
        
        $this->_view();
    }

    public function deleteAction() {
        $id = $this->filterInt($this->_params[0]);
        $user = UserModel::getByPK($id);
        if($user === false || $this->session->user->UserId === $id){
            $this->redirect('/MVCProject/public/users');
            exit();
        }
        $this->language->load('users&messages');
        UserModel::deleteUserProfile($id);
        if($user->delete()){
            $this->messenger->add($this->language->get('message_delete_success'));
        }else{
            $this->messenger->add($this->language->get('message_delete_failed'), Messenger::APP_MESSAGE_ERROR);
        }

        $this->redirect('/MVCProject/public/users');
    }
    
    public function checkUserExistAjaxAction()
    {
        if(isset($_POST['UserName']))
        {
            header('Content-type: text/plain');
           if(UserModel::userExist($this->filterString($_POST['UserName'])) !== false)
           {
                echo 1;
           }else{
                echo 2;
           }
        }
    }
}