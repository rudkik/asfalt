<?php defined('SYSPATH') or die('No direct script access.');

class Model_Driver_DBBasicFrom extends  Model {

	// название таблицы
	public $tableName = '';
	
	//список таблиц для связи
    protected $_fields = array();
	
	// связь таблиц
	const JOIN_LEFT=1;
	const JOIN_RIGHT=2;
	const JOIN_INNER=3;
	
	public function getTables(){
		$tables = array();
		foreach ($this->_fields as $value) {
			$tables[$value['table_name_1']] = '';
			$tables[$value['table_name_2']] = '';
		}
	
		$result = array();
		foreach ($tables as $key => $value) {
			$result[] = $key;
		}
		
		if (count($result) === 0){
			$result[] = $this->tableName;
		}
	
		return $result;
	}

    /**
     * добавляем связь таблиц
     * @param $tableName1
     * @param $fieldName1
     * @param $tableName2
     * @param $fieldName2
     * @param int $join
     * @param string $sql
     * @param bool $isLanguage
     * @param string $key
     * @return string - название новой таблицы
     */
	public function addTable($tableName1, $fieldName1, $tableName2, $fieldName2 = 'id', $join = self::JOIN_LEFT,
                             $sql = '', $isLanguage = FALSE, $key = '')
	{
	    if(empty($key)) {
            $key = $tableName2 . '__' . $fieldName1;
        }
	    if(key_exists($key, $this->_fields)){
            if(strlen($sql) > strlen($this->_fields[$key]['sql'])){
                $this->_fields[$key]['sql'] = $sql;
            }

            $this->_fields[$key]["join"] = $join;

            return $key;

	        if($this->_fields[$key]['table_name_1'] == $tableName1){
                if(strlen($sql) > strlen($this->_fields[$key]['sql'])){
                    $this->_fields[$key]['sql'] = $sql;
                }

                $this->_fields[$key]["join"] = $join;

                return $key;
            }

	        return self::addTable($tableName1, $fieldName1, $tableName2, $fieldName2, $join, $sql = '', $isLanguage, $key.'_1');
        }

        if(empty($sql) && $isLanguage){
            $sql = $tableName1 . '.language_id=' . $tableName2 . '.language_id';
        }

        $this->_fields[$key] = array(
            "table_name_1" => $tableName1,
            "field_name_1" => $fieldName1,
            "table_name_2" => $tableName2,
            "field_name_2" => $fieldName2,
            "join" => $join,
            'sql' => $sql,
            'new_table_name' => $key,
        );

        return $key;
	}

	/** получаем строку запрос
	 * Возвращает SQLстроку
	 */
	public function getSQL()
	{
	}

    /**
     * Находим объединена ли база данных с указанной таблицой
     * @param $tableName
     * @param $fieldName
     * @return bool
     */
    public function isFindTable($tableName, $fieldName = '')
    {
        return key_exists($tableName.'__'.$fieldName, $this->_fields);
    }
}
