<?php defined('SYSPATH') or die('No direct script access.');


class Model_Shop_Table_Preview extends Model_Shop_Basic_Object{

	const TABLE_NAME = 'ct_shop_table_previews';
	const TABLE_ID = 9;

	public function __construct(){
		parent::__construct(
			array(
				'object_id',
				'table_id',
				'shop_table_catalog_id',
				'preview_count',
				'sales_count',
				'storage_count',
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

		$validation->rule('remarketing', 'max_length', array(':value', 650000));

		return $this->_validationFields($validation, $errorFields);
	}

	// Ремаркетинг
	public function setRemarketing($value){
		$this->setValue('remarketing', $value);
	}

	public function getRemarketing(){
		return $this->getValue('remarketing');
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
