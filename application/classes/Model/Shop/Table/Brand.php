<?php defined('SYSPATH') or die('No direct script access.');


class Model_Shop_Table_Brand extends Model_Shop_Basic_Remarketing{

	const TABLE_NAME = 'ct_shop_table_brands';
	const TABLE_ID = 3;

	public function __construct(){
		parent::__construct(
			array(
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

		$validation->rule('remarketing', 'max_length', array(':value', 65000));

		return $this->_validationFields($validation, $errorFields);
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
