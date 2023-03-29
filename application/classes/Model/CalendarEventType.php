<?php defined('SYSPATH') or die('No direct script access.');

class Model_CalendarEventType extends Model_Basic_Name{

    const CALENDAR_EVENT_ONE = 150; // Единоразово
    const CALENDAR_EVENT_WEEK_DAYS = 151; // По дням неделям
    const CALENDAR_EVENT_DAILY = 152; // Ежедневно
    const CALENDAR_EVENT_MONTH = 153; // Ежемесячно
	
	const TABLE_NAME='ct_calendar_event_types';
	const TABLE_ID = 153;

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

		$validation->rule('fields_options', 'max_length', array(':value', 650000));

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
    public function setFieldsOptionsArray(array $value){
        $this->setValueArray('fields_options', $value);
    }
    public function getFieldsOptionsArray(){
        return $this->getValueArray('fields_options');
    }
}
