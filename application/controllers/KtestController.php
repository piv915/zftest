<?php
// hack for loading
require_once('/web/zftest/library/K/Searchable.php');

class KtestController extends Zend_Controller_Action
{
    public function indexAction()
    {

        echo '<pre>';

        $searchRequest = new K_SimpleSearchRequest();
        $searchRequest
            ->addCriteria(K_CriteriaFactory::create('name', K_CriteriaOperator_Eq::create('Vasya')))
            ->addCriteria(K_CriteriaFactory::create('surname', K_CriteriaOperator_Eq::create('Pupkin')))
            ->addCriteria(K_CriteriaFactory::create('age', K_CriteriaOperator_Range::create(array(15, 85))))
            ->addCriteria(new K_Criteria('city', K_CriteriaOperator_Starts::create('Mos')))
            ->addCriteria(new K_Criteria('street', K_CriteriaOperator_Ends::create('na')));
        echo $searchRequest, "\n";

        $searchRequest = new K_SimpleSearchRequest();
        $searchRequest
            ->addCriteria(new K_Criteria('city', K_CriteriaOperator_Starts::create(array('Mos', 'Мос'))));
        echo $searchRequest, "\n";

        $engine = new K_SearchEngine();
        $result = $engine->search($searchRequest);

        var_dump($result);
        echo highlight_string(file_get_contents(__FILE__));
    }
}
