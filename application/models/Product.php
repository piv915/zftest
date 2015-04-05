<?php

class Application_Model_Product
{
    private $id;
    private $item;
    private $cost;

    public function __construct($id)
    {
        $table = new Application_Model_DbTable_Product();
        $row = $table->find($id);
        if ($row->count() == 0) {
            throw new Exception('Product not exists');
        }
        $this->id = $id;
        $this->item = $row->getRow(0)->toArray();

        $this->cost = new P_Currency_Value(
            new P_Currency_Converter(),
            P_Currency_Value::UNIT,
            $this->item['cost_units']
        );
    }

    public function getTitle()
    {
        return $this->item['title'];
    }

    public function getCost($currencyId = null)
    {
        return $this->cost->convert($currencyId)->format();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}
