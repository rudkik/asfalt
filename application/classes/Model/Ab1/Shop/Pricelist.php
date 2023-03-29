<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Pricelist extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_pricelists';
	const TABLE_ID = 405;

	public function __construct(){
		parent::__construct(
			array(),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}

	/**
	 * Получение данных для вспомогательных элементов из базы данных
	 * и добавление его в массив
	 */
	public function dbGetElements($shopID = 0, $elements = NULL){
		if(($elements === NULL) || (! is_array($elements))){
		}else{
			foreach($elements as $element){
				switch($element){
					case 'shop_client_id':
						$this->_dbGetElement($this->getShopClientID(), 'shop_client_id', new Model_Ab1_Shop_Client(), $shopID);
						break;
					case 'shop_product_id':
						$this->_dbGetElement($this->getShopProductID(), 'shop_product_id', new Model_Ab1_Shop_Product());
						break;
					case 'shop_driver_id':
						$this->_dbGetElement($this->getShopDriverID(), 'shop_driver_id', new Model_Ab1_Shop_Driver(), $shopID);
						break;
					case 'shop_turn_id':
						$this->_dbGetElement($this->getShopTurnID(), 'shop_turn_id', new Model_Ab1_Shop_Turn(), $shopID);
						break;
				}
			}
		}

		parent::dbGetElements($shopID, $elements);
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

	public function setFromAt($value){
		$this->setValueDateTime('from_at', $value);
	}
	public function getFromAt(){
		return $this->getValue('from_at');
	}

	public function setToAt($value){
		$this->setValueDateTime('to_at', $value);
	}
	public function getToAt(){
		return $this->getValue('to_at');
	}
}
