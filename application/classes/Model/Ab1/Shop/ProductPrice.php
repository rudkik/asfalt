<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_ProductPrice extends Model_Shop_Basic_Object{

	const TABLE_NAME = 'ab_shop_product_prices';
	const TABLE_ID = 63;

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
			->rule('shop_pricelist_id', 'max_length', array(':value', 11));

        return $this->_validationFields($validation, $errorFields);
    }

	public function setShopProductID($value){
		$this->setValueInt('shop_product_id', $value);
	}
	public function getShopProductID(){
		return $this->getValueInt('shop_product_id');
	}

	public function setShopPriceListID($value){
		$this->setValueInt('shop_pricelist_id', $value);
	}
	public function getShopPriceListID(){
		return $this->getValueInt('shop_pricelist_id');
	}

	public function setPrice($value){
		$this->setValueFloat('price', $value);
	}
	public function getPrice(){
		return $this->getValueFloat('price');
	}
}
