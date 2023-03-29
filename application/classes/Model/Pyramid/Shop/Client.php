<?php defined('SYSPATH') or die('No direct script access.');

class Model_Pyramid_Shop_Client extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME='np_shop_clients';
	const TABLE_ID = 227;

	public function __construct(){
		parent::__construct(
			array(
				'user_id',
				'email',
				'password',
				'user_hash',
				'root_id',
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

		$validation->rule('email', 'max_length', array(':value', 150))
			->rule('password', 'max_length', array(':value', 150))
			->rule('password', 'not_null')
			->rule('email', 'not_null')
			->rule('user_hash', 'max_length', array(':value', 32));
        $this->isValidationFieldInt('user_id', $validation);
        $this->isValidationFieldInt('root_id', $validation);


		return $this->_validationFields($validation, $errorFields);
	}

    public function setRootID($value){
        $this->setValueInt('root_id', $value);
    }
    public function getRootID(){
        return $this->getValueInt('root_id');
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
}
