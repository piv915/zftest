<?php

class ProductController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $productsModel = new Application_Model_DbTable_Product();
        $saledProducts = $productsModel->getAllonSale();

//        var_dump($saledProducts);

        $this->view->products = $saledProducts;
    }


}
