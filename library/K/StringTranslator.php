<?php
/**
 * Created by PhpStorm.
 * User: piv
 * Date: 04.03.15
 * Time: 14:16
 */

class K_StringTranslator
{
    /**
     *
     */
    const AUTO_DETECT = 'AUTO';
    /**
     *
     */
    const ALL = 'ALL';
    /**
     *
     */
    const ANY = 'ANY';

    /**
     * @var
     */
    private $_from;
    /**
     * @var
     */
    private $_to;

    /**
     * @var
     */
    private $_tables;
    /**
     * @var
     */
    private $_methods;
    /**
     * @var
     */
    private $_directions;

    /**
     * @var string input string
     */
    private $_source;

    /**
     *
     */
    public function __construct()
    {
        $this->_tables = [];
        $this->_methods = [];
        $this->_directions = [];

        $this->registerDefaultDirections();
    }

    /**
     * Register replace table for strtr() php function
     * @param string $from direction name
     * @param string $to direction name
     * @param $table
     */
    public function registerTable($from, $to, $table)
    {
        if(!isset($this->_directions[$from]))
            $this->_directions[$from] = [];
        $this->_directions[$from][$to] = 'table';

        if(!isset($this->_tables[$from]))
            $this->_tables[$from] = [];
        $this->_tables[$from][$to]    =  $table;
    }

    /**
     * @param $from
     * @param $to
     * @param callable $callback
     */
    public function registerCallback($from, $to, callable $callback)
    {
        if(!isset($this->_directions[$from]))
            $this->_directions[$from] = [];
        $this->_directions[$from][$to] = 'callback';

        if(!isset($this->_methods[$from]))
            $this->_methods[$from] = [];
        $this->_methods[$from][$to]    =  $callback;
    }

    /**
     * Transliterate input string to given direction(s)
     * @param string $string input string
     * @param string $from
     * @param string $to
     * @return array
     * @throws Exception
     */
    public function translate($string, $from=self::AUTO_DETECT, $to=self::ALL)
    {
        $result = [$string];

        $this->_source = $string;
        if($from==self::AUTO_DETECT) {
            $this->_autoDetect($this->_source);
        }

        if($to==self::ALL)
            $toList = isset($this->_directions[$this->_from])
                ? array_keys($this->_directions[$this->_from])
                : null;
        else
            $toList = isset($this->_directions[$this->_from][$to]) ? $to : null;

        if(is_null($toList))
            throw new Exception(sprintf('Unknown translate direction [from=%s, to=%s]', $from, $to));

        foreach($toList as $to) {
            $direction = $this->_directions[$this->_from][$to];
            switch($direction) {
                case 'callback':
                    $value = call_user_func_array($this->_methods[$this->_from][$to], array($string));
                    if(false===$value)
                        throw new Exception(sprintf('Error in user callback [from=%s, to=%s]', $this->_from, $to));
                    $result[] = $value;
                    break;
                case 'table':
                    $result[] = strtr($string, $this->_tables[$this->_from][$to]);
                    break;
                default:
                    throw new Exception('Incorrect internal state');
            }
        }
        return $result;
    }

    /**
     * Detect input string direction
     * @param $string
     */
    protected function _autoDetect($string)
    {
        $string = trim($string);
        if(preg_match('/[а-яё]/i', $string)) {
            $this->_from = 'RUS';
        }
        else {
            $this->_from = 'LAT';
        }
    }

    /**
     * Register default RUS=>LAT and LAT=>RUS tables
     */
    private function registerDefaultDirections()
    {
        $this->registerCallback('RUS', 'LAT',
            function ($string)
            {
                $replace = array("А"=>"A","а"=>"a","Б"=>"B","б"=>"b","В"=>"V","в"=>"v","Г"=>"G","г"=>"g","Д"=>"D","д"=>"d",
                    "Е"=>"E","е"=>"e","Ё"=>"E","ё"=>"e","Ж"=>"Zh","ж"=>"zh","З"=>"Z","з"=>"z","И"=>"I","и"=>"i",
                    "Й"=>"I","й"=>"i","К"=>"K","к"=>"k","Л"=>"L","л"=>"l","М"=>"M","м"=>"m","Н"=>"N","н"=>"n","О"=>"O","о"=>"o",
                    "П"=>"P","п"=>"p","Р"=>"R","р"=>"r","С"=>"S","с"=>"s","Т"=>"T","т"=>"t","У"=>"U","у"=>"u","Ф"=>"F","ф"=>"f",
                    "Х"=>"Kh","х"=>"kh","Ц"=>"Tc","ц"=>"tc","Ч"=>"Ch","ч"=>"ch","Ш"=>"Sh","ш"=>"sh","Щ"=>"Shch","щ"=>"shch",
                    "Ы"=>"Y","ы"=>"y","Э"=>"E","э"=>"e","Ю"=>"Iu","ю"=>"iu","Я"=>"Ia","я"=>"ia","ъ"=>"","ь"=>"");
                $string = strtr($string, $replace);
                return($string);
            }
        );

        $lat2rusTable = array_flip(["А"=>"A","а"=>"a","Б"=>"B","б"=>"b","В"=>"V","в"=>"v","Г"=>"G","г"=>"g","Д"=>"D","д"=>"d",
            "Е"=>"E","е"=>"e","Ё"=>"E","ё"=>"e","Ж"=>"Zh","ж"=>"zh","З"=>"Z","з"=>"z","И"=>"I","и"=>"i",
            "К"=>"K","к"=>"k","Л"=>"L","л"=>"l","М"=>"M","м"=>"m","Н"=>"N","н"=>"n","О"=>"O","о"=>"o",
            "П"=>"P","п"=>"p","Р"=>"R","р"=>"r","С"=>"S","с"=>"s","Т"=>"T","т"=>"t","У"=>"U","у"=>"u","Ф"=>"F","ф"=>"f",
            "Х"=>"Kh","х"=>"kh","Ц"=>"Tc","ц"=>"tc","Ч"=>"Ch","ч"=>"ch","Ш"=>"Sh","ш"=>"sh","Щ"=>"Sch","щ"=>"Sch",
            "Ы"=>"Y","ы"=>"y","Э"=>"E","э"=>"e","Ю"=>"Iu","ю"=>"iu","Я"=>"Ia","я"=>"ia"]);
        $this->registerTable('LAT', 'RUS',$lat2rusTable);
    }
}