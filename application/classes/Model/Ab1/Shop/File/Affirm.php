<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_File_Affirm extends Model_Shop_Basic_Object{

	const TABLE_NAME = 'ed_shop_file_affirms';
	const TABLE_ID = 128;

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
                    case 'shop_file_id':
                        $this->_dbGetElement($this->getShopFileID(), 'shop_file_id', new Model_Ab1_Shop_File_Affirm());
                        break;
                    case 'shop_operation_id':
                        $this->_dbGetElement($this->getShopOperationID(), 'shop_operation_id', new Model_Shop_Operation());
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
        $validation->rule('shop_file_id', 'max_length', array(':value', 11))
            ->rule('shop_operation_id', 'max_length', array(':value', 11))
            ->rule('is_affirm', 'max_length', array(':value', 1));

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopFileID($value){
        $this->setValueInt('shop_file_id', $value);
    }
    public function getShopFileID(){
        return $this->getValueInt('shop_file_id');
    }

    public function setShopOperationID($value){
        $this->setValueInt('shop_operation_id', $value);
    }
    public function getShopOperationID(){
        return $this->getValueInt('shop_operation_id');
    }

    public function setDate($value){
        $this->setValueDateTime('date', $value);
    }
    public function getDate(){
        return $this->getValueDateTime('date');
    }

    public function setIsAffirm($value){
        $this->setValueDateTime('is_affirm', $value);
    }
    public function getIsAffirm(){
        return $this->getValueDateTime('is_affirm');
    }
}
