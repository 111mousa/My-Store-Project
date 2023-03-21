<?php
namespace PHPMVC\Controllers;
use PHPMVC\Models\ClientModel;
use PHPMVC\Lib\InputFilter;
use PHPMVC\Lib\Helper;
use PHPMVC\Lib\Messenger;

class ClientsController extends AbstractController
{
    use InputFilter;
    use Helper;
    
    private $_createActionRoles = 
    [
        'Name'      => 'req|alpha|between(3,40)',
        'Email'         => 'req|email',
        'Address'        => 'req|alphanum|max(50)',
        'PhoneNumber'   => 'alphanum|max(15)' ,
    ];

    public function defaultAction()
    {
        $this->language->load('template&common');
        $this->language->load('clients&default');
        $this->_data['clients'] = ClientModel::getAll();
        $this->_view();
    }
    
    public function createAction() {
        $this->language->load('template&common');
        $this->language->load('clients&create');
        $this->language->load('clients&labels');
        $this->language->load('validation&errors');
        $this->language->load('clients&messages');
        
        if(isset($_POST['submit'])&&$this->isValid($this->_createActionRoles, $_POST))
        {
            $client = new ClientModel();
            $client->Name = $this->filterString($_POST['Name']);
            $client->Email = $this->filterString($_POST['Email']);
            $client->PhoneNumber = $this->filterString($_POST['PhoneNumber']);
            $client->Address = $this->filterString($_POST['Address']);
            
            if($client->save()){
                $this->messenger->add($this->language->get('message_create_success'));
            }else{
                $this->messenger->add($this->language->get('message_create_failed'), Messenger::APP_MESSAGE_ERROR);
            }
            $this->redirect('/MVCProject/public/clients');
        }
        $this->_view();
    }

    public function editAction() {
        $id = $this->filterInt($this->_params[0]);
        $client = ClientModel::getByPK($id);
        
        if($client === false)
        {
            $this->redirect('/MVCProject/public/clients');
        }
        
        $this->_data['client'] = $client;
        $this->language->load('template&common');
        $this->language->load('clients&edit');
        $this->language->load('clients&labels');
        $this->language->load('validation&errors');
        $this->language->load('clients&messages');
        
        if(isset($_POST['submit'])&&$this->isValid($this->_createActionRoles, $_POST))
        {
            $client->PhoneNumber = $this->filterString($_POST['PhoneNumber']);
            $client->Name = $this->filterString($_POST['Name']);
            $client->Email = $this->filterString($_POST['Email']);
            $client->Address = $this->filterString($_POST['Address']);
            
            if($client->save()){
                $this->messenger->add($this->language->get('message_create_success'));
            }else{
                $this->messenger->add($this->language->get('message_create_failed'), Messenger::APP_MESSAGE_ERROR);
            }
            $this->redirect('/MVCProject/public/clients');
        }
        
        $this->_view();
    }

    public function deleteAction() {
        $id = $this->filterInt($this->_params[0]);
        $client = ClientModel::getByPK($id);
        if($client === false ){
            $this->redirect('/MVCProject/public/supplier');
        }
        $this->language->load('clients&messages');
        if($client->delete()){
            $this->messenger->add($this->language->get('message_delete_success'));
        }else{
            $this->messenger->add($this->language->get('message_delete_failed'), Messenger::APP_MESSAGE_ERROR);
        }

        $this->redirect('/MVCProject/public/clients');
    }
    
}