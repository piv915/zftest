<?php

class Application_Model_Order extends Application_Model_Cart
{

    private $id;
    private $userId;
    /*
     * @var DateTime
     */
    private $dateCreate;
    private $status;

//    private $isEmpty;
    /*
     * @var K_UserIdProvider
     */
    private $idProvider;

    public function __construct(K_UserIdProvider $idProvider)
    {
        $this->idProvider = $idProvider;
//        $this->isEmpty = true;
    }

    public function createFromCart(Application_Model_Cart $cart)
    {
        $statusModel = new Application_Model_DbTable_OrderStatus();

        $this->items = $cart->getItems();
        $this->status = $statusModel->getIdBySysName(Application_Model_DbTable_OrderStatus::NEW_ORDER);
        $this->dateCreate = new DateTime();
        $this->userId = $this->idProvider->getId();

        $this->save();
    }

    public function save()
    {
        $orderModel = new Application_Model_DbTable_Order();
        $orderRow = $orderModel->find($this->id);

//        var_dump($this->id); var_dump($orderRow);

        if(!count($orderRow))
        {
            $orderRow = $orderModel->createRow([
                'user_id' => $this->userId,
                'date_create' => $this->dateCreate->format('Y-m-d H:i:s'),
                'cost_units'  => $this->getSumUnits(),
                'status_id'   => $this->status
            ]);
            $this->id = $orderRow->save();

            $productsModel = new Application_Model_DbTable_OrderProduct();
            foreach ($this->items as $productId => $productRecord)
            {
//                $product = $productRecord[0];
                $count   = $this->getCountFromRecord($productRecord);

                $row = $productsModel->createRow([
                    'order_id' => $this->id,
                    'product_id' => $productId,
                    'items_count' => $count
                ]);
                $row->save();
            }
        }
        else {
            $orderRow = $orderRow[0];
        }
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    public function loadById($orderId)
    {
        $orderModel = new Application_Model_DbTable_Order();
        $orderRow = $orderModel->find($orderId);

        if(!count($orderRow)) {
            throw new Exception('No such order');
        }

        $productsModel = new Application_Model_DbTable_OrderProduct();
        $rows = $productsModel->fetchAll($productsModel->select()->where('order_id = ? ', $orderId))->toArray();
        $items = [];
        foreach ($rows as $row) {
            $items[$row['product_id']] = [ new Application_Model_Product($row['product_id']), $row['items_count'] ];
        }
        $this->items = $items;
        $this->id = $orderId;
    }

    public function getDescription()
    {
        return 'Заказ №'.$this->getId().' на сайте SITENAME';
    }
}

