<?php  defined('SYSPATH') or die('No direct script access.');

class Model_Shop_Bill_Status extends Model_Shop_Basic_Text{

	const TABLE_NAME='ct_shop_bill_statuses';
	const TABLE_ID = 20;

	public function __construct(){
		parent::__construct(
			array(
				'shop_table_catalog_id'
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
	public function validationFields(array &$errorFields){
		$validation = new Validation($this->getValues());

		$validation->rule('shop_table_catalog_id', 'max_length', array(':value', 11));

		return $this->_validationFields($validation, $errorFields);
	}

	// Название статуса
	public function setShopTableCatalogID($value){
		$this->setValueInt('shop_table_catalog_id', $value);
	}
	public function getShopTableCatalogID(){
		return $this->getValueInt('shop_table_catalog_id');
	}
}
