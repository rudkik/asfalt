<?php defined('SYSPATH') or die('No direct script access.');


class Model_Shop_Table_Child extends Model_Shop_Basic_Remarketing{

	const TABLE_NAME = 'ct_shop_table_childs';
	const TABLE_ID = 12;

	public function __construct(){
		parent::__construct(
			array(
				'root_table_id',
				'shop_root_table_catalog_id',
				'shop_root_table_object_id',
			),
			self::TABLE_NAME,
			self::TABLE_ID
		);

		$this->isAddCreated = TRUE;
        $this->isCreateUser = TRUE;
	}

	/**
	 * Проверяем поля на ошибки
	 * @param array $errorFields - массив ошибок
	 * @return boolean
	 */
	public function validationFields(array &$errorFields){
		$validation = new Validation($this->getValues());

		$validation->rule('root_table_id', 'max_length', array(':value', 11))
			->rule('shop_root_table_catalog_id', 'max_length', array(':value', 11))
			->rule('shop_root_table_object_id', 'max_length', array(':value', 11));

		if ($this->isFindFieldAndIsEdit('root_table_id')){
			$validation->rule('root_table_id', 'digit');
		}

		if ($this->isFindFieldAndIsEdit('shop_root_table_catalog_id')){
			$validation->rule('shop_root_table_catalog_id', 'digit');
		}

		if ($this->isFindFieldAndIsEdit('shop_root_table_object_id')){
			$validation->rule('shop_root_table_object_id', 'digit');
		}

		return $this->_validationFields($validation, $errorFields);
	}

	//
	public function setRootTableID($value){
		$this->setValue('root_table_id', intval($value));
	}

	public function getRootTableID(){
		return intval($this->getValue('root_table_id'));
	}

	//
	public function setShopRootTableObjectID($value){
		$this->setValue('shop_root_table_object_id', intval($value));
	}

	public function getShopRootTableObjectID(){
		return intval($this->getValue('shop_root_table_object_id'));
	}

	//
	public function setShopRootTableCatalogID($value){
		$this->setValue('shop_root_table_catalog_id', intval($value));
	}

	public function getShopRootTableCatalogID(){
		return intval($this->getValue('shop_root_table_catalog_id'));
	}

	public function setDownloadFilePath($value){
		$this->setValue('download_file_path', $value);
	}

	public function getDownloadFilePath(){
		return $this->getValue('download_file_path');
	}

	public function setDownloadFileName($value){
		$this->setValue('download_file_name', $value);
	}

	public function getDownloadFileName(){
		return $this->getValue('download_file_name');
	}
}
