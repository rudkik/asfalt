<?php defined('SYSPATH') or die('No direct script access.');


class Model_Tax_Shop_ECP extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'tax_shop_ecps';
	const TABLE_ID = 163;

	public function __construct(){
		parent::__construct(
			array(
                'auth_password',
                'gostknca_password',
                'auth_file',
                'auth_name',
                'gostknca_file',
                'gostknca_name',
            ),
			self::TABLE_NAME,
			self::TABLE_ID
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
        $validation->rule('auth_password', 'max_length', array(':value', 50))
            ->rule('gostknca_password', 'max_length', array(':value', 50))
            ->rule('auth_file', 'max_length', array(':value', 250))
            ->rule('auth_name', 'max_length', array(':value', 250))
            ->rule('gostknca_file', 'max_length', array(':value', 250))
            ->rule('gostknca_name', 'max_length', array(':value', 250));

        return $this->_validationFields($validation, $errorFields);
    }

    public function setAuthPassword($value){
        $this->setValue('auth_password', $value);
    }
    public function getAuthPassword(){
        return $this->getValue('auth_password');
    }

    public function setGostkncaPassword($value){
        $this->setValue('gostknca_password', $value);
    }
    public function getGostkncaPassword(){
        return $this->getValue('gostknca_password');
    }

    public function setAuthFile($value){
        $this->setValue('auth_file', $value);
    }
    public function getAuthFile(){
        return $this->getValue('auth_file');
    }

    public function setAuthName($value){
        $this->setValue('auth_name', $value);
    }
    public function getAuthName(){
        return $this->getValue('auth_name');
    }

    public function setGostkncaFile($value){
        $this->setValue('gostknca_file', $value);
    }
    public function getGostkncaFile(){
        return $this->getValue('gostknca_file');
    }

    public function setGostkncaName($value){
        $this->setValue('gostknca_name', $value);
    }
    public function getGostkncaName(){
        return $this->getValue('gostknca_name');
    }
}
