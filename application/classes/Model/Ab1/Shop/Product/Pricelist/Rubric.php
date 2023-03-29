<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Product_Pricelist_Rubric extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_product_pricelist_rubrics';
	const TABLE_ID = 325;

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
                    case 'root_id':
                        $this->_dbGetElement($this->getRootID(), 'root_id', new Model_Ab1_Shop_Product_Pricelist_Rubric(), $shopID);
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
        $validation->rule('root_id', 'max_length', array(':value', 11));

        return $this->_validationFields($validation, $errorFields);
    }

	public function setRootID($value){
		$this->setValueInt('root_id', $value);
	}
	public function getRootID(){
		return $this->getValueInt('root_id');
	}
}
