<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_File_Type extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ed_shop_file_types';
	const TABLE_ID = 125;

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
                    case 'file_type_id':
                        $this->_dbGetElement($this->getFileTypeID(), 'file_type_id', new Model_Ab1_File_Type());
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
        $validation->rule('file_type_id', 'max_length', array(':value', 11));

        return $this->_validationFields($validation, $errorFields);
    }

	public function setFileTypeID($value){
		$this->setValueInt('file_type_id', $value);
	}
	public function getFileTypeID(){
		return $this->getValueInt('file_type_id');
	}
}
