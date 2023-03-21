<?php
namespace PHPMVC\Controllers;
use PHPMVC\Models\PrivilegeModel;
use PHPMVC\Lib\InputFilter;
use PHPMVC\Lib\Helper;
use PHPMVC\Models\UserGroupPrivilegeModel;

class PrivilegesController extends AbstractController
{
    use InputFilter;
    use Helper;
    
    public function defaultAction()
    {
        $this->language->load('template&common');
        $this->language->load('privileges&default');
        $this->_data['privileges'] = PrivilegeModel::getAll();
        $this->_view();
    }
    public function createAction() {
        $this->language->load('template&common');
        $this->language->load('privileges&labels');
        $this->language->load('privileges&create');
        
        if(isset($_POST['submit'])){
            $privilege = new PrivilegeModel();
            $privilege->setPrivilegeTitle($this->filterString($_POST['PrivilegeTitle']));
            $privilege->setPrivilege($this->filterString($_POST['Privilege']));
            if($privilege->save())
            {
                $this->messenger->add('تم حفظ الصلاحية بنجاح');
                $this->redirect('/MVCProject/public/privileges');
            }
        }
        $this->_view();
    }
    public function editAction() {
        $id = $this->filterInt($this->_params[0]);
        $privilege = PrivilegeModel::getByPK($id);
        
        if($privilege === false){
            $this->redirect('/MVCProject/public/privileges');
            exit();
        }
        $this->_data['privilege'] = $privilege;
        $this->language->load('template&common');
        $this->language->load('privileges&labels');
        $this->language->load('privileges&edit');
        
        if(isset($_POST['submit'])){
            $privilege->setPrivilegeTitle($this->filterString($_POST['PrivilegeTitle']));
            $privilege->setPrivilege($this->filterString($_POST['Privilege']));
            if($privilege->save())
            {
                $this->redirect('/MVCProject/public/privileges');
            }
        }
        $this->_view();
    }
    public function deleteAction() {
        $id = $this->filterInt($this->_params[0]);
        $privilege = PrivilegeModel::getByPK($id);
        
        if($privilege === false){
            $this->redirect('/MVCProject/public/privileges');
            exit();
        }
        
        $groupPrivileges = UserGroupPrivilegeModel::getBy(['PrivilegeId' => $privilege->PrivilegeId]);
        
        if($groupPrivileges !== false){
            foreach($groupPrivileges as $groupPrivilege){
                $groupPrivilege->delete();
            }
        }
        
        if($privilege->delete()){
            $this->redirect('/MVCProject/public/privileges');
        }
    }
}