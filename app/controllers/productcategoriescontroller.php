<?php

namespace PHPMVC\Controllers;
use PHPMVC\Lib\Messenger;
use PHPMVC\Models\ProductCategoryModel;
use PHPMVC\Lib\FileUpload;
use PHPMVC\Lib\Helper;
use PHPMVC\Lib\InputFilter;
use PHPMVC\Lib\Validate;

class ProductCategoriesController extends AbstractController {

    use InputFilter;
    use Helper;
    use Validate;

    private $_createActionRoles = [
        'CategoryName'      =>      'req|alpha|between(3,30)'
    ];
    public function defaultAction() {
        $this->language->load('template&common');
        $this->language->load('productcategories&default');
        $this->_data['categories'] = ProductCategoryModel::getAll();
        $this->_view();
    }

    public function createAction() {
        $this->language->load('template&common');
        $this->language->load('productcategories&create');
        $this->language->load('productcategories&messages');
        $this->language->load('productcategories&labels');
        $this->language->load('validation&errors');
        
        $uploadError = false;
        
        if (isset($_POST['submit'])&& $this->isValid($this->_createActionRoles, $_POST)) {
            $category = new ProductCategoryModel();
            $category->CategoryName = $this->filterString($_POST['CategoryName']);
            if(!empty($_FILES['CategoryImage']['name'])){
                $uploader = new FileUpload($_FILES['CategoryImage']);
                try{
                    $uploader->upload();
                    $category->CategoryImage = $uploader->getFileName();
                } catch (Exception $ex) {
                    $this->messenger->add($ex->getMessage(),Messenger::APP_MESSAGE_ERROR);
                    $uploadError = true;
                }
            }
            
            if ($uploadError === false && $category->save()) {
                $this->messenger->add($this->language->get('message_create_success'));
            }else{
                $this->messenger->add($this->language->get('message_create_failed'),Messenger::APP_MESSAGE_ERROR);
            }
            $this->redirect('/MVCProject/public/productcategories');
        }
        $this->_view();
    }

    public function editAction() {
        $id = $this->filterInt($this->_params[0]);
        $category = ProductCategoryModel::getByPK($id);
        if ($category === false) {
            $this->redirect('/MVCProject/public/productcategories');
        }
        $this->language->load('template&common');
        $this->language->load('productcategories&edit');
        $this->language->load('productcategories&messages');
        $this->language->load('productcategories&labels');
        $this->language->load('validation&errors');

        $this->_data['category'] = $category;
        $uploadError = false;
        
        if (isset($_POST['submit'])) {
            $category->CategoryName = $this->filterString($_POST['CategoryName']);
            if(!empty($_FILES['CategoryImage']['name'])){
                if($category->CategoryImage !== '' && file_exists(IMAGES_UPLOAD_STORAGE.DS.$category->CategoryImage)&& is_writable(IMAGES_UPLOAD_STORAGE)){
                    unlink(IMAGES_UPLOAD_STORAGE.DS.$category->CategoryImage);
                }else{
                    $this->messenger->add($this->language->get('message_create_failed'),Messenger::APP_MESSAGE_ERROR);
                }
                if(!empty($_FILES['CategoryImage']['name'])){
                    $uploader = new FileUpload($_FILES['CategoryImage']);
                    try{
                        $uploader->upload();
                        $category->CategoryImage = $uploader->getFileName();
                    } catch (Exception $ex) {
                        $this->messenger->add($ex->getMessage(),Messenger::APP_MESSAGE_ERROR);
                        $uploadError = true;
                    }
                }
            }
            
            if ($uploadError === false && $category->save()) {
                $this->messenger->add($this->language->get('message_create_success'));
            }else{
                $this->messenger->add($this->language->get('message_create_failed'),Messenger::APP_MESSAGE_ERROR);
            }
            $this->redirect('/MVCProject/public/productcategories');
        }  
        
        $this->_view();
    }
    
    public function deleteAction() 
    {
        $id = $this->filterInt($this->_params[0]);
        $category = ProductCategoryModel::getByPK($id);
        if($category === false){
            $this->redirect('/MVCProject/public/productcategories');
        }
        
        $this->language->load('productcategories&messages');
        
        if($category->delete()){
            if($category->CategoryImage !== '' && file_exists(IMAGES_UPLOAD_STORAGE.DS.$category->CategoryImage)){
                    unlink(IMAGES_UPLOAD_STORAGE.DS.$category->CategoryImage);
            }
            $this->messenger->add($this->language->get('message_delete_success'));
        }else{
            $this->messenger->add($this->language->get('message_delete_failed'));
        }
        $this->redirect('/MVCProject/public/productcategories');
    }

}
