<?php

class Application_Model_Cart
{
    protected $items;

    public function __construct()
    {
        $this->items = [];
    }

    public function addProduct(Application_Model_Product $product, $count=1)
    {
        if(!$this->isProductInCart($product)) {
            $this->items[$product->getId()] = [$product, $count];
        }
        else {
            $this->updateProduct($product, $count);
        }
    }

    public function updateProduct(Application_Model_Product $product, $countDelta)
    {
        if($this->isProductInCart($product)) {
            $productId = $product->getId();
            $count     = $this->getCountFromRecord($this->items[$productId]);
            $newCount  = $count + $countDelta;
            if($newCount <= 0) {
                $this->deleteProduct($product);
            }
            else {
                $this->items[$productId][1] = $newCount;
            }
        }
    }

    public function deleteProduct(Application_Model_Product $product)
    {
        if($this->isProductInCart($product))
            unset ($this->items[$product->getId()]);
    }

    public function getItemsCount(Application_Model_Product $product=null)
    {
        $count = 0;
        if(!is_null($product) && $this->isProductInCart($product)) {
            $productRecord = $this->items[$product->getId()];
            $count += $this->getCountFromRecord($productRecord);
        }
        foreach ($this->items as $productId => $productRecord) {
            $count += $this->getCountFromRecord($productRecord);
        }
        return $count;
    }

    public function isProductInCart(Application_Model_Product $product)
    {
        $productId = $product->getId();
        return array_key_exists($productId, $this->items);
    }

    public function getSum(Application_Model_Product $product=null)
    {
        $sum = 0.0;

        if(empty($this->items))
            return $sum;

        if(!is_null($product) && $this->isProductInCart($product)) {
            $record = $this->items[$product->getId()];
            $sum = $product->getCost() * $this->getCountFromRecord($record);
        }

        if(is_null($product)) {
            foreach ($this->items as $productId => $productRecord) {
                $sum += (float)$productRecord[0]->getCost() * $this->getCountFromRecord($productRecord);
            }
        }

        return $sum;
    }

    public function getSumUnits()
    {
        $sum = 0.0;
        foreach ($this->items as $productId => $productRecord) {
            $sum += (float)$productRecord[0]->getCost(P_Currency_Value::UNIT)
                * $this->getCountFromRecord($productRecord);
        }
        return $sum;
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    protected function getCountFromRecord(array $productRecord)
    {
        return $productRecord[1];
    }

}

