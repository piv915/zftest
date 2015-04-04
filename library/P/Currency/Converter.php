<?php
/**
 * Created by PhpStorm.
 * User: piv
 * Date: 27.03.15
 * Time: 20:49
 */

class P_Currency_Converter
{
    const DEFAULT_CURRENCY_ID = P_Currency_Value::USD;

    public function __construct()
    {
        // TODO: Implement __construct() method.
    }

    public function convertCurrency(P_Currency_Value $currency, $toCurrencyId=null)
    {
        $toCurrencyId  = is_null($toCurrencyId) ? self::DEFAULT_CURRENCY_ID : $toCurrencyId;

        $result = new P_Currency_Value(new P_Currency_Converter(), $toCurrencyId);

        $courseList = new Application_Model_DbTable_CurrencyCourse();
        $course = $courseList->fetchRow(
            $courseList->select()
                ->where('currency_id_from = ?', $currency->getId())
                ->where('currency_id_to = ?', $result->getId())
        );

        $course = !$course  ? 1 : $course->course;

        $result->setValue($course * $currency->getValue());

        return $result;
    }
}
