<?php

class P_Robox_API
{
    const ERROR_INCORRECT_LANGUAGE = -2;
    const ERROR_TEST_DISABLED = -1;
    const ERROR_INVALID_CURRENCY_LABEL = -3;

    const ERROR_MERCHANT_NOTFOUND = 2;
    const ERROR_ROBOKASSA_INTERNAL = 1000;

    const ERROR_INVALID_SIGNATURE = 1;
    const ERROR_INVOICE_NOTFOUND  = 3;

    const ERROR_INVALID_XML = 2000;
    const OK = 0;

    private $config;
    private $language;

    public function __construct($language=null)
    {
        $reader = new Zend_Config_Ini('/web/zftest/application/configs/robox.ini');
        $this->config = $reader->robokassa;
        $this->language = $language ? $language : 'en';
    }

    public function getCurrencies($flatten=false)
    {
        $name = 'GetCurrencies';

        $doc = null;
        list($code, $message) = $this->request([], $name, $doc);
        if($code != self::OK) {
            throw new Exception($message, $code);
        }
        $xpath = new DOMXPath($doc);

        $result = [];
        if($flatten) {
            $query = '//Items/Currency';
            $currencyList = $this->xQuery($xpath, $query, $doc->documentElement->namespaceURI);
            foreach($currencyList as $elem) {
                if($elem->nodeName == 'Currency' && $elem->nodeType == XML_ELEMENT_NODE) {
                    $result[$elem->getAttribute('Label')] = $elem->getAttribute('Name');
                }
            }
        }
        else {
            $query = '/*/Groups/*';
            $groups = $this->xQuery($xpath, $query, $doc->documentElement->namespaceURI);

            foreach ($groups as $element) {
                if($element->nodeName == 'Group' && $element->nodeType == XML_ELEMENT_NODE) {
                    $groupCode = $element->getAttribute('Code');
                    $result[$groupCode] = [
                        'description' => $element->getAttribute('Description'),
                        'items' => []
                    ];
                    $query = 'Items/Currency';
                    $currencyList = $this->xQuery($xpath, $query, $doc->documentElement->namespaceURI, $element);
                    foreach($currencyList as $elem) {
                        if($elem->nodeName == 'Currency' && $elem->nodeType == XML_ELEMENT_NODE) {
                            $result[$groupCode]['items'][] = [
                                'label' => $elem->getAttribute('Label'),
                                'name'  => $elem->getAttribute('Name')
                            ];
                        }
                    }
                }
            }
        }

        return $result;
    }

    public function getPaymentMethods()
    {
        $name = 'GetPaymentMethods';

        $doc = null;
        list($code, $message) = $this->request([], $name, $doc);
        if($code != self::OK) {
            throw new Exception($message, $code);
        }
        $xpath = new DOMXPath($doc);

        $query = '/*/Methods/*';
        $methods = $this->xQuery($xpath, $query, $doc->documentElement->namespaceURI);

        $result = [];
        foreach ($methods as $element) {
            if($element->nodeName == 'Method' && $element->nodeType == XML_ELEMENT_NODE) {
                $code = $element->getAttribute('Code');
                $result[$code] = [
                    'description' => $element->getAttribute('Description'),
                ];
            }
        }
        return $result;
    }

    public function getRates($outSum, $inCurrencyLabel=null)
    {
        $name = 'GetRates';

        $doc = null;
        $data = ['outSum' => $outSum];
        $data['IncCurrLabel'] = strval($inCurrencyLabel);

        list($code, $message) = $this->request($data, $name, $doc);
        if($code != self::OK) {
            throw new Exception($message, $code);
        }
        $xpath = new DOMXPath($doc);

        $query = '//Currency';
        $list = $this->xQuery($xpath, $query, $doc->documentElement->namespaceURI);

        $result = [];
        foreach ($list as $element) {
            if($element->nodeName == 'Currency' && $element->nodeType == XML_ELEMENT_NODE) {
                $label = $element->getAttribute('Label');
                $result[$label] = [];

                $query = 'Rate';
                $currencyList = $this->xQuery($xpath, $query, $doc->documentElement->namespaceURI, $element);
                foreach($currencyList as $elem) {
                    if($elem->nodeName == 'Rate' && $element->nodeType == XML_ELEMENT_NODE) {
                        $result[$label] = $elem->getAttribute('IncSum');
                    }
                }
            }
        }
        return $result;
    }

    /**
     * @return null|string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    public function getFormParams($outSum, $invoiceId)
    {
        $result = [
            'MrchLogin' => $this->config->merchantid,
            'OutSum' => $outSum,
            'InvId' => $invoiceId
        ];
        $result['SignatureValue'] = md5($this->config->merchantid . ":$outSum:$invoiceId:" . $this->config->pass1);
        $result['payUrl'] = $this->config->payUrl;

        return $result;
    }

    protected function calcOutSum($outSum)
    {
        $name = 'CalcOutSumm';

    }

    public function opState($invoiceId)
    {
        $name = 'OpState';

        $doc = null;
        $data = [
            'MerchantLogin' => $this->config->merchantid,
            'InvoiceID' => $invoiceId
        ];
        $this->signData($data, $this->config->pass2);
        $data['Language'] = $this->language;

        if(strpos($this->config->url, 'test')!==false)
        {
            $fakeCodes = [1,5,10,50,60,80,100];
            $data['StateCode'] = $fakeCodes[rand(0, count($fakeCodes)-1)];
        }

        list($code, $message) = $this->request($data, $name, $doc, null, true);
        if($code != self::OK) {
            throw new Exception($message, $code);
        }
        $xpath = new DOMXPath($doc);

        $result = [];

        $query = '//State/*';
        $list = $this->xQuery($xpath, $query, $doc->documentElement->namespaceURI);
        foreach($list as $element) {
            if($element->nodeType != XML_ELEMENT_NODE)
                continue;

            if ($element->nodeName == 'Code')
                $result['code'] = $element->nodeValue;

            if ($element->nodeName == 'RequestDate')
                $result['request_date'] = $element->nodeValue;

            if ($element->nodeName == 'StateDate')
                $result['state_date'] = $element->nodeValue;
        }

        $query = '//Info/*';
        $list = $this->xQuery($xpath, $query, $doc->documentElement->namespaceURI);

        $result['in'] = [];
        $result['out'] = [];

        foreach($list as $element) {
            if($element->nodeType != XML_ELEMENT_NODE)
                continue;

            if($element->nodeName == 'IncCurrLabel')
                $result['in']['label'] = $element->nodeValue;

            if($element->nodeName == 'IncSum')
                $result['in']['sum'] = $element->nodeValue;

            if($element->nodeName == 'OutCurrLabel')
                $result['out']['label'] = $element->nodeValue;

            if($element->nodeName == 'OutSum')
                $result['out']['sum'] = $element->nodeValue;

        }
        return $result;
    }

    protected function request(array $data, $name, &$dom, $url=null, $sign=false)
    {
        $common_data = [
            'MerchantLogin' => $this->config->merchantid,
            'Language'      => $this->language
        ];

        if(!$sign) {
            $data = $common_data + $data;
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_URL, (is_null($url) ? $this->config->url : $url). '/' . $name);

        curl_setopt($curl, CURLOPT_POSTFIELDS, $this->serialize($data));
        $response = curl_exec($curl);
        curl_close($curl);

        $xmlParsed = null;
        $doc = new DOMDocument();
        $doc->preserveWhiteSpace = false;
        try {
            $xmlParsed = $doc->loadXML($response);
        } catch(Exception $ex)
        {
            // TODO: handle exception
        }

        if(!$xmlParsed)
            return [self::ERROR_INVALID_XML, $response];

//        echo $response;

        list($code, $message) = $this->getResultCode($doc);

        $dom = $doc;
        return [$code, $message];
    }

    /**
     * @param array $data
     * @return string
     */
    protected function serialize(array $data)
    {
        $result = [];
        foreach ($data as $key => $value) {
            $result[] = $key.'='.$value;
        }
        return join('&', $result);
    }

    /**
     * @param DOMXpath $xpath
     * @param $query
     * @param null $ns
     * @param null $contextNode
     * @return DOMNodeList
     */
    protected function xQuery(DOMXpath $xpath, $query, $ns=null, $contextNode=null) {
        if(!empty($ns)) {
            $xpath->registerNameSpace('def', $ns);
            $query = preg_replace_callback(
                '#(\w+)#',
                function($m) {
                    return str_replace($m[0], "def:{$m[0]}", $m[0]);
                }, $query);
        }
        return is_null($contextNode) ? $xpath->query($query) : $xpath->query($query, $contextNode);
    }

    /**
     * @param DOMDocument $doc
     * @return array
     */
    protected function getResultCode(DOMDocument $doc)
    {
        $code = null;
        $message = null;

        $ns = $doc->documentElement->namespaceURI;

        $xpath = new DOMXPath($doc);

        $query = '/*/Result/*';
        $list = $this->xQuery($xpath, $query, $ns);

        foreach ($list as $e) {
            if ($e->nodeName == 'Code')
                $code = $e->nodeValue;
            if ($e->nodeName == 'Description')
                $message = $e->nodeValue;
        }

        return [$code, $message];
    }

    protected function signData(array &$data, $secret)
    {
        $stringToSign = '';
        foreach ($data as $key => $value) {
            $stringToSign .= $value.':';
        }

        $stringToSign .= $secret;
        $signature = md5($stringToSign);
        $data['Signature'] = $signature;
    }
}
