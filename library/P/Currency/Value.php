<?php
/**
 * Created by PhpStorm.
 * User: piv
 * Date: 27.03.15
 * Time: 20:44
 */

class P_Currency_Value
{
    const UNIT = 1;
    const RUR  = 2;
    const USD  = 3;

    /*
     * @var id currency Id
     */
    private $id;
    /*
     * @var value amount
     */
    private $value;
    /*
     * @var P_Currency_Converter
     */
    private $converter;

    public function __construct(P_Currency_Converter $converter, $id, $value = 0)
    {
        $this->id = $id;
        $this->value = $value;
        $this->converter = $converter;
    }

    public function __toString()
    {
        return $this->format();
    }


    /**
     * @param null $toCurrencyId
     * @return P_Currency_Value
     */
    public function convert($toCurrencyId=null)
    {
        return $this->converter->convertCurrency($this, $toCurrencyId);
    }

    public function format()
    {
        return sprintf("%.2f", $this->value);
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

}
