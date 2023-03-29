<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Driver extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_drivers';
	const TABLE_ID = 64;

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
    public function validationFields(array &$errorFields)
    {
        $validation = new Validation($this->getValues());
        $validation->rule('shop_client_id', 'max_length', array(':value', 11));

        return $this->_validationFields($validation, $errorFields);
    }

	public function setShopClientID($value){
		$this->setValueInt('shop_client_id', $value);
	}
	public function getShopClientID(){
		return $this->getValueInt('shop_client_id');
	}
}
