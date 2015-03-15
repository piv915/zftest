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

    public function formAction()
    {
        $request = $this->getRequest();
        $form    = new Application_Form_AddPlace();

        if ($request->isPost())
        {

            $form->isValid($request->getPost());
//            $form->populate($request->getPost());
            $data = $form->getValues();
            var_dump($data['attributes']['data']);
            $validData = $form->getValidValues($data);
//            var_dump($validData);

//            if ($form->isValid($request->getPost()))
//            {
//                exit();
//            }
//            else
//            {
//                $data = $form->getValues();
//            }
        }
//        $coll = $form->getCollection('collection1');
//        var_dump($coll);

        $this->view->form = $form;
        $t = $form->getSubForm($form::ATTRIBUTES)->getTemplate();
        $this->view->attributesTemplate = $t;
    }

}

