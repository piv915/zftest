<?php
/**
 * Created by PhpStorm.
 * User: piv
 * Date: 27.02.15
 * Time: 21:58
 */

interface K_Searchable
{
    public function setDataProvider(K_DataProvider $provider);

    /**
     * @param K_SearchRequest $request
     * @return K_SearchResult
     */
    public function search(K_SearchRequest $request);
}

abstract class K_SearchResult implements ArrayAccess
{
    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        //throw new Exception(__CLASS__.' readonly');
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     */
    public function offsetUnset($offset)
    {
        //throw new Exception(__CLASS__.' readonly');
    }

}

class K_RowsSearchResult extends K_SearchResult
{
    private $_data;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->_data = $data;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     */
    public function offsetExists($offset)
    {
        return isset($this->_data);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     */
    public function offsetGet($offset)
    {
        return $this->_data[$offset];
    }

}

abstract class K_SearchRequest
{
    protected $fieldsCollection;
    protected $criteriaCollection;

    /**
     * @param K_Field $field
     * @return K_SearchRequest
     */
    abstract public function addField(K_Field $field);

    /**
     * @param K_Criteria $criteria
     * @return K_SearchRequest
     */
    abstract public function addCriteria(K_Criteria $criteria);

    public function __toString()
    {
        $result = array();
        foreach($this->criteriaCollection as $criteria) {
            $result[] = (string)$criteria;
        }
        return sprintf('SELECT * WHERE %s', join(', ', $result));
    }

}

class K_CriteriaFactory
{
    public static function create($field, K_CriteriaOperator $operator)
    {
        return new K_Criteria($field, $operator);
    }
}

interface K_CriteriaOperatorInterface
{
    /**
     * @param $value
     * @return bool
     * @throws Exception
     */
    public static function isValid($value);

    /**
     * @param $value
     * @return K_CriteriaOperator
     */
    public static function create($value);
}

abstract class K_CriteriaOperator implements K_CriteriaOperatorInterface
{
    protected $_op;
    protected $_value;

    abstract public function __toString();

    /**
     * @return mixed
     */
    public function getOp()
    {
        return $this->_op;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->_value;
    }

}


class K_CriteriaOperator_Less extends K_CriteriaOperator
{
    /**
     * @param $value
     * @return bool
     * @throws Exception
     */
    public static function isValid($value)
    {
        if(!is_scalar($value))
            throw new Exception('Value must be a scalar');
        return true;
    }

    /**
     * @param $value
     * @return K_CriteriaOperator
     */
    public static function create($value)
    {
        return self::isValid($value) ? new self('<', $value) : null;
    }

    protected function __construct($operatorPresentation, $value)
    {
        $this->_op = $operatorPresentation;
        $this->_value = $value;
    }

    public function __toString()
    {
        return sprintf('%s %s', $this->_op, $this->_value);
    }
}
class K_CriteriaOperator_More extends K_CriteriaOperator
{
    /**
     * @param $value
     * @return bool
     * @throws Exception
     */
    public static function isValid($value)
    {
        if(!is_scalar($value))
            throw new Exception('Value must be a scalar');
        return true;
    }

    /**
     * @param $value
     * @return K_CriteriaOperator
     */
    public static function create($value)
    {
        return self::isValid($value) ? new self('>', $value) : null;
    }

    protected function __construct($operatorPresentation, $value)
    {
        $this->_op = $operatorPresentation;
        $this->_value = $value;
    }

    public function __toString()
    {
        return sprintf('%s %s', $this->_op, $this->_value);
    }
}
class K_CriteriaOperator_Eq extends K_CriteriaOperator
{
    /**
     * @param $value
     * @return bool
     * @throws Exception
     */
    public static function isValid($value)
    {
        if(!is_scalar($value))
            throw new Exception('Value must be a scalar');
        return true;
    }

    /**
     * @param $value
     * @return K_CriteriaOperator
     */
    public static function create($value)
    {
        return self::isValid($value) ? new self('=', $value) : null;
    }

    protected function __construct($operatorPresentation, $value)
    {
        $this->_op = $operatorPresentation;
        $this->_value = $value;
    }

    public function __toString()
    {
        return sprintf('%s %s', $this->_op, $this->_value);
    }
}

class K_CriteriaOperator_Starts extends K_CriteriaOperator
{
    /**
     * @param $value
     * @return bool
     * @throws Exception
     */
    public static function isValid($value)
    {
        // TODO: check all array values are strings
        $valid = is_string($value) || (is_array($value));
        if(!$valid)
            throw new Exception('Value must be a string');
        return true;
    }

    /**
     * @param $value
     * @return K_CriteriaOperator
     */
    public static function create($value)
    {
        return self::isValid($value) ? new self('STARTS_WITH', $value) : null;
    }

    protected function __construct($operatorPresentation, $value)
    {
        $this->_op = $operatorPresentation;
        $this->_value = $value;
    }

    public function __toString()
    {
        return sprintf('%s %s', $this->_op, is_array($this->_value)? join('|', $this->_value) : $this->_value);
    }
}
class K_CriteriaOperator_Ends extends K_CriteriaOperator
{
    /**
     * @param $value
     * @return bool
     * @throws Exception
     */
    public static function isValid($value)
    {
        if(!is_scalar($value))
            throw new Exception('Value must be a scalar');
        return true;
    }

    /**
     * @param $value
     * @return K_CriteriaOperator
     */
    public static function create($value)
    {
        return self::isValid($value) ? new self('ENDS_WITH', $value) : null;
    }

    protected function __construct($operatorPresentation, $value)
    {
        $this->_op = $operatorPresentation;
        $this->_value = $value;
    }

    public function __toString()
    {
        return sprintf('%s %s', $this->_op, $this->_value);
    }
}

class K_CriteriaOperator_Range extends K_CriteriaOperator
{
    /**
     * @param $value
     * @return bool
     * @throws Exception
     */
    public static function isValid($value)
    {
        $valid = is_array($value) && count($value) == 2;
        // TODO: and has equal scalar type
        if(!$valid)
            throw new Exception('Value must be a scalar');
        return true;
    }

    /**
     * @param $value
     * @return K_CriteriaOperator
     */
    public static function create($value)
    {
        return self::isValid($value) ? new self('..', $value) : null;
    }

    protected function __construct($operatorPresentation, $value)
    {
        $this->_op = $operatorPresentation;

        // reindex
        $end = array_pop($value);
        $begin = array_pop($value);

        $this->_value = array($begin, $end);
    }

    public function __toString()
    {
        return sprintf('INRANGE(%s%s%s)', $this->_value[0], $this->_op, $this->_value[1]);
    }
}

class K_Criteria
{
    protected $field;
//    protected $value;
    protected $operator;

    /**
     * @return mixed
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @param mixed $field
     */
    public function setField($field)
    {
        $this->field = $field;
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
    public function getOperator()
    {
        return $this->operator;
    }

    public function __toString()
    {
        return sprintf('%s %s', $this->field, $this->operator);
    }

    public function __construct($field, K_CriteriaOperator $operator)
    {
        $this->field = $field;
        $this->operator = $operator;
    }

}

class K_Field
{
    protected $field;

    /**
     * @return mixed
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @param mixed $field
     */
    public function setField($field)
    {
        $this->field = $field;
    }

    public function __construct($field)
    {
        $this->field = $field;
    }

}

abstract class K_DataProvider
{
    /**
     * @return K_SearchResult
     */
    abstract public function getResult();
}

class K_TableDataProvider extends K_DataProvider
{
    public function __construct()
    {

    }

    /**
     * @return K_SearchResult
     */
    public function getResult()
    {
        return array(
            array('id' => 8, 'name' => 'Vasya', 'surname' => 'Pupkin', 'birth_date' => '2008-01-01', 'gender' => 1, 'age' => 26, 'city' => 'Moscow', 'street' => 'Lenina'),
            array('id' => 72, 'name' => 'Masha', 'surname' => 'Petrova', 'birth_date' => '1988-01-01', 'gender' => 2, 'age' => 22),
        );
    }
}

class K_SearchEngine implements K_Searchable
{
    protected $dataProvider;

    public function setDataProvider(K_DataProvider $provider)
    {
        $this->dataProvider = $provider;
    }

    /**
     * @param K_SearchRequest $request
     * @return K_SearchResult
     */
    public function search(K_SearchRequest $request)
    {
        // TODO: Implement search() method.
    }
}

class K_SimpleSearchRequest extends K_SearchRequest
{

    public function addField(K_Field $field)
    {
        $this->fieldsCollection[] = $field;
    }

    /**
     * @param K_Criteria $criteria
     * @return K_SearchRequest
     */
    public function addCriteria(K_Criteria $criteria)
    {
        $this->criteriaCollection[] = $criteria;
        return $this;
    }
}
