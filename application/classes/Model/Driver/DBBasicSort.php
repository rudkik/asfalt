<?php defined('SYSPATH') or die('No direct script access.');

class Model_Driver_DBBasicSort extends  Model {

	//список полей для отоброжения
	protected $_fields = array();

    /**
     * добавляем поле для отоброженияя
     * @param $tableName
     * @param $fieldName
     * @param bool $asc
     * @param bool $isProcessing
     */
	public function addField($tableName, $fieldName, $asc = TRUE, $isProcessing = TRUE)
	{
		$this->_fields[$tableName.'__'.$fieldName] = array(
		    'table' => $tableName,
            'field' => $fieldName,
            'asc' => $asc,
            'is_processing' => $isProcessing,
        );
	}

	/** получаем строку запрос
	 * Возвращает SQLстроку
	 */
	public function getSQL()
	{

	}

}

