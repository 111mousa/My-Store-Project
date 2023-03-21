<?php

namespace PHPMVC\Controllers;

use PHPMVC\Models\ProductCategoryModel;
use PHPMVC\Models\ProductModel;
use PHPMVC\Lib\FileUpload;
use PHPMVC\Lib\Helper;
use PHPMVC\Lib\InputFilter;
use PHPMVC\Lib\Validate;

class ProductsListController extends AbstractController {

    use InputFilter;
    use Helper;
    use Validate;

    private $_createActionRoles = [
        'CategoryId' => 'req|num',
        'Name' => 'req|alpha|between(3,50)',
        'BuyPrice' => 'req|num',
        'SellPrice' => 'req|num',
        'Unit' => 'req|num',
        'Quantity' => 'req|num'
    ];

    public function defaultAction() {
        $this->language->load('template&common');
        $this->language->load('productslist&default');
        $this->_data['products'] = ProductModel::getAll();
        $this->_view();
    }

    public function createAction() {
        $this->language->load('template&common');
        $this->language->load('productslist&create');
        $this->language->load('productslist&messages');
        $this->language->load('productslist&labels');
        $this->language->load('productslist&units');
        $this->language->load('validation&errors');

        $this->_data['categories'] = ProductCategoryModel::getAll();

        if (isset($_POST['submit']) && $this->isValid($this->_createActionRoles, $_POST)) {
            $product = new ProductModel();
            $product->Name = $this->filterString($_POST['Name']);
            $product->CategoryId = $this->filterInt($_POST['CategoryId']);
            $product->BuyPrice = $this->filterFloat($_POST['BuyPrice']);
            $product->SellPrice = $this->filterFloat($_POST['SellPrice']);
            $product->Quantity = $this->filterInt($_POST['Quantity']);
            $product->Unit = $this->filterInt($_POST['Unit']);

            $uploadError = false;

            if (!empty($_FILES['Image']['name'])) {
                $uploader = new FileUpload($_FILES['Image']);
                try {
                    $uploader->upload();
                    $product->Image = $uploader->getFileName();
                } catch (Exception $ex) {
                    $this->messenger->add($ex->getMessage(), Messenger::APP_MESSAGE_ERROR);
                    $uploadError = true;
                }
            }

            if ($uploadError === false && $product->save()) {
                $this->messenger->add($this->language->get('message_create_success'));
            } else {
                $this->messenger->add($this->language->get('message_create_failed'), Messenger::APP_MESSAGE_ERROR);
            }
            $this->redirect('/MVCProject/public/productslist');
        }
        $this->_view();
    }

    public function editAction() {
        $id = $this->filterInt($this->_params[0]);
        $product = ProductModel::getByPK($id);
        if ($product === false) {
            $this->redirect('/MVCProject/public/productslist');
        }
        $this->language->load('template&common');
        $this->language->load('productslist&create');
        $this->language->load('productslist&messages');
        $this->language->load('productslist&labels');
        $this->language->load('productslist&units');
        $this->language->load('validation&errors');

        $this->_data['product'] = $product;
        $this->_data['categories'] = ProductCategoryModel::getAll();
        
        $uploadError = false;

        if (isset($_POST['submit']) && $this->isValid($this->_createActionRoles, $_POST)) {
            $product->Name = $this->filterString($_POST['Name']);
            $product->CategoryId = $this->filterInt($_POST['CategoryId']);
            $product->BuyPrice = $this->filterFloat($_POST['BuyPrice']);
            $product->SellPrice = $this->filterFloat($_POST['SellPrice']);
            $product->Quantity = $this->filterInt($_POST['Quantity']);
            $product->Unit = $this->filterInt($_POST['Unit']);

            $uploadError = false;

            if (!empty($_FILES['Image']['name'])) {
                $uploader = new FileUpload($_FILES['Image']);
                try {
                    $uploader->upload();
                    $product->Image = $uploader->getFileName();
                } catch (Exception $ex) {
                    $this->messenger->add($ex->getMessage(), Messenger::APP_MESSAGE_ERROR);
                    $uploadError = true;
                }
            }

            if ($uploadError === false && $product->save()) {
                $this->messenger->add($this->language->get('message_create_success'));
            } else {
                $this->messenger->add($this->language->get('message_create_failed'), Messenger::APP_MESSAGE_ERROR);
            }
            $this->redirect('/MVCProject/public/productslist');
        }
        $this->_view();
    }

    public function deleteAction() {
        $id = $this->filterInt($this->_params[0]);
        $product = ProductModel::getByPK($id);
        if ($product === false) {
            $this->redirect('/MVCProject/public/productslist');
        }

        $this->language->load('productslist&messages');

        if ($product->delete()) {
            if ($product->Image !== '' && file_exists(IMAGES_UPLOAD_STORAGE . DS . $product->Image)) {
                unlink(IMAGES_UPLOAD_STORAGE . DS . $product->Image);
            }
            $this->messenger->add($this->language->get('message_delete_success'));
        } else {
            $this->messenger->add($this->language->get('message_delete_failed'));
        }
        $this->redirect('/MVCProject/public/productslist');
    }

}
