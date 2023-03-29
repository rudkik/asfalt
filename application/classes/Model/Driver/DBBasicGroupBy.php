<?php defined('SYSPATH') or die('No direct script access.');

class Model_Driver_DBBasicGroupBy extends  Model {

    // список полей для отоброжения
	protected $_fields = array();

    /**
     * список полей для отоброжения
     * @return array
     */
	function getFields(){
	    return $this->_fields;
    }

	/** добавляем поле для отоброженияя
	 * $tableName- название таблицы
	 * $fieldName - название поля таблицы
	 */
	public function addField($tableName, $fieldName)
	{
		$this->_fields[]=array('table' => $tableName, 'field' => $fieldName);
	}
	
	/**
	 * Добавляем поле для отоброжения с функцией 
	 * Пример DATE($fieldName)
	 * @param string $tableName - название таблицы
	 * @param string $fieldName - название поля таблицы
	 * @param string $functionName - название функции
	 */
	public function addFunctionField($tableName, $fieldName, $functionName)
	{
		$this->_fields[]=array('table' => $tableName, 'field' => $fieldName, 
				'function_name' => $functionName);
	}

	/** получаем строку запрос
	 * Возвращает SQLстроку
	 */
	public function getSQL()
	{

	}

}

