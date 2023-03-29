<?php defined('SYSPATH') or die('No direct script access.');

class Model_Driver_DBBasicSelect extends  Model
{

	const FUNCTION_SUM = 'sum';
	const FUNCTION_COUNT = 'count';

	//список полей для отоброжения
	protected $_fields = array();

    /**
     * добавляем поле для отоброжения без корректировки
     * @param $tableName - название таблицы
     * @param $fieldName - название поля таблицы
     * @param string $newName
     */
    public function addFieldNotCorrect($tableName, $fieldName, $newName = '')
    {
        $this->_fields[$tableName.'_'.$fieldName.'_'.$newName] = array(
            'table' => $tableName,
            'field' => $fieldName,
            'new' => $newName,
            'is_correct' => FALSE,
        );
    }

    /**
     * добавляем поле для отоброжения
     * @param $tableName - название таблицы
     * @param $fieldName - название поля таблицы
     * @param string $newName
     * @return $this
     */
	public function addField($tableName, $fieldName, $newName = '')
	{
		$this->_fields[$tableName.'_'.$fieldName.'_'.$newName] = array('table' => $tableName, 'field' => $fieldName, 'new' => $newName);

		return $this;
	}

    /**
     * удаляем поле для отоброжения
     * @param $tableName - название таблицы
     * @param $fieldName - название поля таблицы
     * @param string $newName
     */
    public function deleteField($tableName, $fieldName, $newName = '')
    {
        unset($this->_fields[$tableName.'_'.$fieldName.'_'.$newName]);
    }

	/**
	 * Добавляем поле для отоброжения с функцией
	 * Пример DATE($fieldName)
	 * @param string $tableName - название таблицы
	 * @param string $fieldName - название поля таблицы
	 * @param string $functionName - название функции
	 * @param string $newName - новое название поля таблицы
	 */
	public function addFunctionField($tableName, $fieldName, $functionName, $newName = '')
	{
		$this->_fields[] = array('table' => $tableName, 'field' => $fieldName,
			'new' => $newName, 'function_name' => $functionName);
	}

	/** получаем строку запрос
	 * Возвращает SQLстроку
	 */
	public function getSQL()
	{

	}

	/**
	 * @return array
	 */
	public function getFields()
	{
		return $this->_fields;
	}

	/**
	 * @param array $fields
	 */
	public function setFields(array $fields)
	{
		$this->_fields = $fields;
	}
}

