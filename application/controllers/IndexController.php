<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $query = ['Aуди X5',
         'Audi X5',
         'Khadorkovskiy'];
        $query[] = $this->getParam("query");

        $translator = new K_StringTranslator();
        $queryList = [];
        foreach($query as $input) {
            $queryList[] = $translator->translate($input);
        }

        $a=$b=$c=null;

        $o = new Object();
        $o
            ->not()->criteria('name', $a)
            ->and()
                ->group()
                    ->criteria('age', $b)
                    ->criteria('age', $c)
                ->endGroup()
        ;

//        var_dump($translator);
        var_dump($queryList);
        exit();
    }


}

