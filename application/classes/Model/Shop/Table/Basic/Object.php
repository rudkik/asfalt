<?php defined('SYSPATH') or die('No direct script access.');


class Model_Shop_Table_Basic_Object extends Model_Shop_Basic_SEO{

	public function __construct(array $overallLanguageFields, $tableName, $tableID, $isTranslate = TRUE){
        array_push($overallLanguageFields,
            'shop_table_catalog_id',
            'table_id');

		parent::__construct($overallLanguageFields, $tableName, $tableID, $isTranslate);
	}

    public function dbGetElements($shopID = 0, $elements = NULL){
		if(($elements === NULL) || (! is_array($elements))){
		}else{
			foreach($elements as $element){
				switch($element){
					case 'shop_table_catalog_id':
						$this->_dbGetElement($this->getShopTableCatalogID(), 'shop_table_catalog_id', new Model_Shop_Table_Catalog(), $shopID);
						break;
					case 'table_id':
						$this->_dbGetElement($this->getShopTableCatalogID(), 'table_id', new Model_Table());
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
	public function validationFields(array &$errorFields){
		$validation = new Validation($this->getValues());

		$validation->rule('shop_table_catalog_id', 'max_length', array(':value', 11))
			->rule('table_id', 'max_length', array(':value', 11));

		if (($this->id < 1) || ($this->isFindFieldAndIsEdit('shop_table_catalog_id'))){
			$validation->rule('shop_table_catalog_id', 'digit');
		}

		if (($this->id < 1) || ($this->isFindFieldAndIsEdit('table_id'))){
			$validation->rule('table_id', 'digit');
		}

		return $this->_validationFields($validation, $errorFields);
	}

	// ID каталога статьи
	public function setShopTableCatalogID($value){
		$this->setValue('shop_table_catalog_id', intval($value));
	}
	public function getShopTableCatalogID(){
		return intval($this->getValue('shop_table_catalog_id'));
	}

	// ID каталога статьи
	public function setTableID($value){
		$this->setValue('table_id', intval($value));
	}
	public function getTableID(){
		return intval($this->getValue('table_id'));
	}
}
