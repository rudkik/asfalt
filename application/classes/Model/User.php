<?php defined('SYSPATH') or die('No direct script access.');

class Model_User extends Model_Basic_DBValue{

	const TABLE_NAME = 'ct_users';
	const TABLE_ID = 29;

	// пол человека
	const OPTIONS_IS_MEN = 1;
	const OPTIONS_IS_WOMEN = 2;

	public function __construct(){
		parent::__construct(
			array(
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
            $arr['options'] = $this->getOptionsArray();
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

    /**
     * @param array $value
     * @param bool $isAddAll - добавлять все записи или только новые
     */
    public function addOptionsArray(array $value, $isAddAll = TRUE, $key = null){
        $tmp = $this->getOptionsArray();

        foreach($value as $k => $v){
            if($isAddAll || (! key_exists($k, $tmp) || empty($tmp[$k]))) {
                $tmp[$k] = $v;
            }
        }

        $this->setOptionsArray($tmp);
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

	public function setName($value){
		$this->setValue('name', $value);
	}

	public function getName(){
		return $this->getValue('name');
	}
}
