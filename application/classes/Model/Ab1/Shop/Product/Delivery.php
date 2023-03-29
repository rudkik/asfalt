<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Product_Delivery extends Model_Shop_Basic_Object{

	const TABLE_NAME = 'ab_shop_product_deliveries';
	const TABLE_ID = 151;

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
			->rule('shop_delivery_id', 'max_length', array(':value', 11));

        return $this->_validationFields($validation, $errorFields);
    }

	public function setShopProductID($value){
		$this->setValueInt('shop_product_id', $value);
	}
	public function getShopProductID(){
        return $this->getValueInt('shop_product_id');
	}

	public function setShopDeliveryID($value){
		$this->setValueInt('shop_delivery_id', $value);
	}
	public function getShopDeliveryID(){
		return $this->getValueInt('shop_delivery_id');
	}
}
