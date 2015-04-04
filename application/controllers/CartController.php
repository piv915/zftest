<?php

class CartController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $cart = $this->getCart();
        $this->view->cart = $cart;
    }

    public function checkoutAction()
    {
        $cart = $this->getCart();
        $order = new Application_Model_Order(new K_UserIdProvider());

        $orderId = $this->getParam('order_id', null);
        $paymentProvider = $this->getParam('pp', null);

        if(!$orderId) {
            $order->createFromCart($cart);
            $orderId = $order->getId();
        }
        else {
            $order->loadById($orderId);
        }

        if($paymentProvider) {
            $factory = new P_ProcessorFactory();
            $processor = $factory->createProcessor($this);

            $paymentMethods = $processor->getPaymentMethods($order->getSumUnits());
            $this->view->paymentMethods = $paymentMethods;

            $paymentMethod = $this->getParam('payment_method', null);
            if($paymentMethod) {
                $formText = $processor->buildRedirectForm($order, $paymentMethod);
                $this->view->payForm = $formText;
            }
        }



        $this->view->order = $order;
    }

    /**
     * @return Application_Model_Cart
     */
    private function getCart()
    {
        $cart = new Application_Model_Cart();

        // TODO: get cart from application/session/form etc.
//        $cart->addProduct(new Application_Model_Product(1), 2);
//        $cart->addProduct(new Application_Model_Product(2), 1);
//        $cart->addProduct(new Application_Model_Product(4), 5);
        $cart->addProduct(new Application_Model_Product(5),1);
        return $cart;
    }
}

