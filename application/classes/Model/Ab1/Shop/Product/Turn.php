<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Product_Turn extends Model_Shop_Basic_Object{

	const TABLE_NAME = 'ab_shop_product_turns';
	const TABLE_ID = 68;

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
        $validation->rule('shop_product_id', 'max_length', array(':value', 11))
			->rule('price', 'max_length', array(':value', 14))
			->rule('shop_turn_type_id', 'max_length', array(':value', 11));

        return $this->_validationFields($validation, $errorFields);
    }

	public function setShopProductID($value){
		$this->setValueInt('shop_product_id', $value);
	}
	public function getShopProductID(){
		return $this->getValueInt('shop_product_id');
	}

	public function setShopTurnTypeID($value){
		$this->setValueInt('shop_turn_type_id', $value);
	}
	public function getShopTurnTypeID(){
		return $this->getValueInt('shop_turn_type_id');
	}

	public function setGroup($value){
		$this->setValueInt('group', $value);
	}
	public function getGroup(){
		return $this->getValueInt('group');
	}
}
