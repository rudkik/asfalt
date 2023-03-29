<?php defined('SYSPATH') or die('No direct script access.');


class Model_Shop_Table_Select extends Model_Shop_Table_Basic_Rubric{

	const TABLE_NAME = 'ct_shop_table_selects';
	const TABLE_ID = 7;

	public function __construct(){
		parent::__construct(
			array(),
			self::TABLE_NAME,
			self::TABLE_ID
		);

		$this->isAddCreated = TRUE;
        $this->isCreateUser = TRUE;
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
