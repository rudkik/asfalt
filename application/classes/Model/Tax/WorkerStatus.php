<?php defined('SYSPATH') or die('No direct script access.');

class Model_Tax_WorkerStatus extends Model_Basic_Name{

    const WORKER_STATUS_NATIONAL = 0; // граждане не вошедшие в другие группы
    const WORKER_STATUS_PENSIONER = 1; // пенсионер
    const WORKER_STATUS_HANDICAPPED = 2; // Инвалид 3 группы
    const WORKER_STATUS_ALIEN = 3; // Иностранец без вида на жительство
    const WORKER_STATUS_ALIEN_NATIONAL = 4; // Иностранец c видом на жительство


	
	const TABLE_NAME='tax_worker_statuses';
	const TABLE_ID = 145;

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

		$validation->rule('fields_options', 'max_length', array(':value', 650000))
            ->rule('options', 'max_length', array(':value', 650000));

		return $this->_validationFields($validation, $errorFields);
	}

	/**
	 * Возвращаем cписок всех переменных
	 */
	public function getValues($isGetElement = FALSE, $isParseArray = FALSE, $shopID = NULL)
	{
		$arr = parent::getValues($isGetElement, $isParseArray, $shopID);

		if($isParseArray === TRUE) {
			$arr['fields_options'] = $this->getFieldsOptionsArray();
			$arr['options'] = $this->getFieldsOptionsArray();
		}

		return $arr;
	}

    // JSON настройки списка полей
    public function setFieldsOptions($value){
        $this->setValue('fields_options', $value);
    }

    public function getFieldsOptions(){
        return $this->getValue('fields_options');
    }

    // JSON настройки списка полей
    public function setFieldsOptionsArray(array $value){
        $this->setValueArray('fields_options', $value);
    }

    public function getFieldsOptionsArray(){
        return $this->getValueArray('fields_options');
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
