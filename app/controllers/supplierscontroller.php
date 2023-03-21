<?php
namespace PHPMVC\Controllers;
use PHPMVC\Models\SupplierModel;
use PHPMVC\Lib\InputFilter;
use PHPMVC\Lib\Helper;
use PHPMVC\Lib\Messenger;

class SuppliersController extends AbstractController
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
        $this->language->load('suppliers&default');
        $this->_data['suppliers'] = SupplierModel::getAll();
        $this->_view();
    }
    
    public function createAction() {
        $this->language->load('template&common');
        $this->language->load('suppliers&create');
        $this->language->load('suppliers&labels');
        $this->language->load('validation&errors');
        $this->language->load('suppliers&messages');
        
        if(isset($_POST['submit'])&&$this->isValid($this->_createActionRoles, $_POST))
        {
            $supplier = new SupplierModel();
            $supplier->Name = $this->filterString($_POST['Name']);
            $supplier->Email = $this->filterString($_POST['Email']);
            $supplier->PhoneNumber = $this->filterString($_POST['PhoneNumber']);
            $supplier->Address = $this->filterString($_POST['Address']);
            
            if($supplier->save()){
                $this->messenger->add($this->language->get('message_create_success'));
            }else{
                $this->messenger->add($this->language->get('message_create_failed'), Messenger::APP_MESSAGE_ERROR);
            }
            $this->redirect('/MVCProject/public/suppliers');
        }
        $this->_view();
    }

    public function editAction() {
        $id = $this->filterInt($this->_params[0]);
        $supplier = SupplierModel::getByPK($id);
        
        if($supplier === false)
        {
            $this->redirect('/MVCProject/public/suppliers');
        }
        
        $this->_data['supplier'] = $supplier;
        $this->language->load('template&common');
        $this->language->load('suppliers&edit');
        $this->language->load('suppliers&labels');
        $this->language->load('validation&errors');
        $this->language->load('suppliers&messages');
        
        if(isset($_POST['submit'])&&$this->isValid($this->_createActionRoles, $_POST))
        {
            $supplier->PhoneNumber = $this->filterString($_POST['PhoneNumber']);
            $supplier->Name = $this->filterString($_POST['Name']);
            $supplier->Email = $this->filterString($_POST['Email']);
            $supplier->Address = $this->filterString($_POST['Address']);
            
            if($supplier->save()){
                $this->messenger->add($this->language->get('message_create_success'));
            }else{
                $this->messenger->add($this->language->get('message_create_failed'), Messenger::APP_MESSAGE_ERROR);
            }
            $this->redirect('/MVCProject/public/suppliers');
        }
        
        $this->_view();
    }

    public function deleteAction() {
        $id = $this->filterInt($this->_params[0]);
        $supplier = SupplierModel::getByPK($id);
        if($supplier == false ){
            $this->redirect('/MVCProject/public/supplier');
        }
        $this->language->load('suppliers&messages');
        if($supplier->delete()){
            $this->messenger->add($this->language->get('message_delete_success'));
        }else{
            $this->messenger->add($this->language->get('message_delete_failed'), Messenger::APP_MESSAGE_ERROR);
        }

        $this->redirect('/MVCProject/public/suppliers');
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