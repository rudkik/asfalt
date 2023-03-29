<?php defined('SYSPATH') or die('No direct script access.');

class Model_Tax_Status extends Model_Basic_Name{

    const TAX_STATUS_START = 1; // Отчет в очереди на сдачу
    const TAX_STATUS_FINISH = 2; // Отчет сдан в налоговую
	
	const TABLE_NAME='tax_statuses';
	const TABLE_ID = 179;

	public function __construct(){
		parent::__construct(
			array(),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}

	/**
	 * Проверяем поля на ошибки
	 * @param array $errorFields - массив ошибок
	 * @return boolean
	 */
	public function validationFields(array &$errorFields){
		$validation = new Validation($this->getValues());

		$validation->rule('options', 'max_length', array(':value', 650000));

		return $this->_validationFields($validation, $errorFields);
	}

	/**
	 * Возвращаем cписок всех переменных
	 */
	public function getValues($isGetElement = FALSE, $isParseArray = FALSE, $shopID = NULL)
	{
		$arr = parent::getValues($isGetElement, $isParseArray, $shopID);

		if($isParseArray === TRUE) {
			$arr['options'] = $this->getFieldsOptionsArray();
		}

		return $arr;
	}

    // JSON настройки списка полей
    public function setOptions($value){
        $this->setValue('options', $value);
    }

    public function getOptions(){
        return $this->getValue('options');
    }

    // JSON настройки списка полей
    public function setOptionsArray(array $value){
        $this->setValueArray('options', $value);
    }

    public function getOptionsArray(){
        return $this->getValueArray('options');
    }
}
