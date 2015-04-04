<?php

class P_Robox_Processor extends P_Processor
{
    const PROVIDER_ID = 1;

    private $prefix;

    public function __construct()
    {
        $this->prefix = (new Application_Model_DbTable_PaymentProvider())->getPrefixById(self::PROVIDER_ID);
    }

    public function createInvoice(Application_Model_Order $order)
    {
        // TODO: Implement createInvoice() method.
        $invoiceId = 1;
        return $invoiceId;
    }

    public function getPaymentMethods($sumUnits=null)
    {
        $model = new Application_Model_DbTable_Currency();
        $methods = $model->getPaymentMethodsForProvider(self::PROVIDER_ID);

        $myCurrencyModelName = 'Application_Model_DbTable_Ps'.ucfirst($this->prefix).'Currency';
        $myCurrencyModel = new $myCurrencyModelName;
        $marks = $myCurrencyModel->getMarks();

        foreach($methods as &$method) {
            foreach($marks as $mark) {
                if($method['id'] == $mark['id']) {
                    $method['mark'] = $mark['mark'];
                    break;
                }
            }
        }

        $api = new P_Robox_API();

        if(!is_null($sumUnits)) {
            $currency = new P_Currency_Value(new P_Currency_Converter(), P_Currency_Value::UNIT, $sumUnits);
            // для робокассы -- в рубли!
            $currencyRur = $currency->convert(P_Currency_Value::RUR);

            $rates = $api->getRates($currencyRur->getValue());
            $actualMethods = array_keys($rates);
        }
        else {
            $actualMethods = array_keys($api->getCurrencies(true));
        }

        $result = [];
        foreach($methods as $method) {
            if(in_array($method['mark'], $actualMethods)) {
                $result[] = [
                    'id' => $method['id'],
                    'title' => $method['title'],
                    'logotype' => $method['logotype'],
                    'sum' => isset($rates) ? $rates[$method['mark']] : null
                ];
            }
        }
        return $result;
    }

    public function handleSuccess()
    {
        // TODO: Implement handleSuccess() method.
    }

    public function handleError()
    {
        // TODO: Implement handleError() method.
    }

    public function buildRedirectForm(Application_Model_Order $order, $currencyId)
    {
        $sumUnits = $order->getSumUnits();
        $currency = new P_Currency_Value(new P_Currency_Converter(), P_Currency_Value::UNIT, $sumUnits);
        // для робокассы -- в рубли!
        $currencyRur = $currency->convert(P_Currency_Value::RUR);

        $api = new P_Robox_API();
        $mandatoryParams = $api->getFormParams($currencyRur->format(), $this->createInvoice($order));

        $formUrl = $mandatoryParams['payUrl'];
        unset($mandatoryParams['payUrl']);

        // TODO: заменить на Zend_Form или общий способ передачи для всех ПС
        $form   = '<form action="'.$formUrl.'" method="post">';
        $params = [];

        $allParams = [];
        $allParams += $mandatoryParams;

        $allParams['Desc'] = $order->getDescription();
        $model = new Application_Model_DbTable_PsRoboxCurrency();
        $allParams['IncCurrLabel'] = $model->find($currencyId)->current()->mark;

        foreach ($allParams as $name => $value) {
            $params[] = '<input type="hidden" name="'.$name.'" value="'.$value.'"/>';
        }
        $form .= join("\n", $params);

        $form .= '<input type="submit" value="Оплатить"/>';
        $form .= '</form>';

        return $form;
    }

    /**
     * @deprecated
     */
    protected function updateCurrencyList()
    {
        $languages = ['en', 'ru'];

        foreach($languages as $lang) {
            $currencies_saved = [];

            $parentModel = new Application_Model_DbTable_Currency();
            $model = new Application_Model_DbTable_PsRoboxCurrency();
            $rowSet = $model->fetchAll();

            foreach ($rowSet as $row) {
                $row = $row->toArray();
                $label = $row['mark'];
                $name  = $row[$lang.'_name'];
                $currencies_saved[$label] = $name;
            }

            $api = new P_Robox_API($lang);
            $currencies = $api->getCurrencies(true);

            foreach($currencies as $label => $name) {
                if(array_key_exists($label, $currencies_saved)) {
                    if($currencies[$label] != $currencies_saved[$label]) {
                        // update name in table
                        $model->update([
                            $lang.'_name' => $name
                        ], $model->getAdapter()->quoteInto('mark = ?', $label));
                    }
                }
                else {
                    $parentRow = $parentModel->createRow([
                        'provider_id' => self::PROVIDER_ID,
                        'sysid' => 'ROBOX_'.substr($label, 0, 6) . rand(10000,99999),
                        'class_id' => Application_Model_DbTable_CurrencyClass::ELECTRONIC
                    ]);
                    $id = $parentRow->save();

                    // insert into table
                    $newRow = $model->createRow([
                        'id' => $id,
                        'mark' => $label,
                        $lang.'_name' => $name
                    ]);
                    $newRow->save();
                }
            }

            foreach($currencies_saved as $label => $name) {
                if(!array_key_exists($label, $currencies)) {
                    $model->delete($model->getAdapter()->quoteInto('mark = ? ', $label));
                }
            }
        }
    }

}
