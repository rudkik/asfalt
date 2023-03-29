<?php defined('SYSPATH') or die('No direct script access.');


class Model_EMailType extends Model_Basic_Name{

	const EMAIL_TYPE_CREATE_BILL = 700;
	const EMAIL_TYPE_CREATE_USER = 701;
	const EMAIL_TYPE_REMEMBER_PASSWORD_USER = 702;
	const EMAIL_TYPE_EDIT_BILL = 703;
	const EMAIL_TYPE_ADD_MESSAGE = 704;
    const EMAIL_TYPE_ADD_SUBSCRIBE = 705;
    const EMAIL_TYPE_UPDATE_CLIENT = 706;

	const TABLE_NAME = 'ct_email_types';
	const TABLE_ID = 39;

	public function __construct()
    {
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

	// JSON настройки списка полей
	public function setFieldsOptionsArray(array $value){
		$this->setValueArray('fields_options', $value);
	}

	public function getFieldsOptionsArray(){
		return $this->getValueArray('fields_options');
	}
}
