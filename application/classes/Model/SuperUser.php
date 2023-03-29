<?php defined('SYSPATH') or die('No direct script access.');

class Model_SuperUser extends Model_Basic_Options{

	const TABLE_NAME = 'ct_super_users';
	const TABLE_ID = 51;

	public function __construct(){
		parent::__construct(
			array(
				'user_id',
				'email',
				'password',
				'user_hash',
				'access'
			),
			self::TABLE_NAME,
			self::TABLE_ID,
			FALSE
		);
	}

	/**
	 * Проверяем поля на ошибки
	 * @param array $errorFields - массив ошибок
	 * @return boolean
	 */
	public function validationFields(array &$errorFields)
	{
		$validation = new Validation($this->getValues());

		if ($this->id < 1) {
			$validation->rule('password', 'not_empty');
			$validation->rule('email', 'not_empty');
		}

		$validation->rule('name', 'max_length', array(':value', 250))
			->rule('user_id', 'max_length', array(':value', 11))
			->rule('email', 'max_length', array(':value', 150))
			->rule('password', 'max_length', array(':value', 150))
			->rule('access', 'max_length', array(':value', 650000))
			->rule('password', 'not_null')
			->rule('email', 'not_null')
			->rule('user_hash', 'max_length', array(':value', 32));

		if ($this->isFindFieldAndIsEdit('user_id')) {
			$validation->rule('user_id', 'digit');
		}

		return $this->_validationFields($validation, $errorFields);
	}

	/**
	 * Возвращаем cписок всех переменных
	 */
	public function getValues($isGetElement = FALSE, $isParseArray = FALSE, $shopID = NULL)
	{
		$arr = parent::getValues($isGetElement, $isParseArray, $shopID);

		if($isParseArray === TRUE) {
			$arr['access'] = $this->getAccessArray();
		}

		return $arr;
	}

	// Пользователь
	public function setUserID($value){
		$this->setValueInt('user_id', $value);
	}

	public function getUserID(){
		return $this->getValueInt('user_id');
	}

	// Пароль
	public function setPassword($value){
		$this->setValue('password', $value);
	}

	public function getPassword(){
		return $this->getValue('password');
	}

	// EMail
	public function setEMail($value){
		$this->setValue('email', $value);
	}

	public function getEMail(){
		return $this->getValue('email');
	}

	// для подключения
	public function setUserHash($value){
		$this->setValue('user_hash', $value);
	}

	public function getUserHash(){
		return $this->getValue('user_hash');
	}

	// JSON настройки списка полей
	public function setAccess($value){
		$this->setValue('access', $value);
	}

	public function getAccess(){
		return $this->getValue('access');
	}

	// JSON настройки списка полей
	public function setAccessArray(array $value){
		$this->setValueArray('access', $value);
	}

	public function getAccessArray()
	{
		return $this->getValueArray('access');
	}
}
