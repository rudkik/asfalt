<?php defined('SYSPATH') or die('No direct script access.');


class Model_Shop_Table_Param extends Model_Shop_Basic_Remarketing{

    const TABLE_NAME = 'ct_shop_table_param_';
    const TABLE_ID = 196;

    public function __construct($index = 1){
        parent::__construct(
            array(

            ),
            self::TABLE_NAME.$index.'s',
            self::TABLE_ID
        );

        $this->isAddCreated = TRUE;
        $this->isCreateUser = TRUE;
    }

    /**
     * @param int $index
     * @return string
     */
    public static function getTableName($index = 1)
    {
        if($index < 1){
            $index = 1;
        }

        return self::TABLE_NAME.$index.'s';
    }

	/**
	 * Проверяем поля на ошибки
	 * @param array $errorFields - массив ошибок
	 * @return boolean
	 */
	public function validationFields(array &$errorFields){
		$validation = new Validation($this->getValues());

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
