<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_File extends Model_Shop_Basic_Collations{

	const TABLE_NAME = 'ed_shop_files';
	const TABLE_ID = 121;

	public function __construct(){
		parent::__construct(
			array(
				'is_group',
			),
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
					case 'shop_table_preview_id':
						$this->_dbGetElement($this->id, 'shop_table_preview', new Model_Shop_Table_Preview());
						break;
                    case 'shop_file_version_id':
                        $this->_dbGetElement($this->getShopFileVersionID(), 'shop_file_version_id', new Model_Ab1_Shop_File_Version());
                        break;
                    case 'root_id':
                        $this->_dbGetElement($this->getRootID(), 'root_id', new Model_Ab1_Shop_File());
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

		$validation->rule('is_group', 'max_length', array(':value', 1))
            ->rule('is_directory', 'max_length', array(':value', 1))
            ->rule('root_id', 'max_length', array(':value', 11))
            ->rule('shop_file_version_id', 'max_length', array(':value', 11))
            ->rule('download_file_path', 'max_length', array(':value', 250));

		if ($this->isFindFieldAndIsEdit('is_group')) {
			$validation->rule('is_group', 'digit');
		}
        if ($this->isFindFieldAndIsEdit('is_directory')) {
            $validation->rule('is_directory', 'digit');
        }
        if ($this->isFindFieldAndIsEdit('root_id')) {
            $validation->rule('root_id', 'digit');
        }
        if ($this->isFindFieldAndIsEdit('shop_file_version_id')) {
            $validation->rule('shop_file_version_id', 'digit');
        }

		return $this->_validationFields($validation, $errorFields);
	}

	// Группа ли
	public function setIsGroup($value){
		$this->setValueBool('is_group', $value);
	}
	public function getIsGroup(){
		return $this->getValueBool('is_group');
	}

    public function setDownloadFilePath($value){
        $this->setValue('download_file_path', $value);
    }
    public function getDownloadFilePath(){
        return $this->getValue('download_file_path');
    }

    public function setRootID($value){
        $this->setValueInt('root_id', $value);
    }
    public function getRootID(){
        return $this->getValueInt('root_id');
    }

    public function setSize($value){
        $this->setValueInt('size', $value);
    }
    public function getSize(){
        return $this->getValueInt('size');
    }

    public function setShopFileVersionID($value){
        $this->setValueInt('shop_file_version_id', $value);
    }
    public function getShopFileVersionID(){
        return $this->getValueInt('shop_file_version_id');
    }

    public function setIsDirectory($value){
        $this->setValueBool('is_directory', $value);
    }
    public function getIsDirectory(){
        return $this->getValueBool('is_directory');
    }

}
