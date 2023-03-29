<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Formula_Group extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_formula_groups';
	const TABLE_ID = 330;

	public function __construct(){
		parent::__construct(
			array(
			    'shop_product_rubric_id',
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
                    case 'shop_product_rubric_id':
                        $this->_dbGetElement($this->getRootID(), 'shop_product_rubric_id', new Model_Ab1_Shop_Product_Rubric(), $shopID);
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
        $validation->rule('shop_product_rubric_id', 'max_length', array(':value', 11));

        return $this->_validationFields($validation, $errorFields);
    }

	public function setShopProductRubricID($value){
		$this->setValueInt('shop_product_rubric_id', $value);
	}
	public function getShopProductRubricID(){
		return $this->getValueInt('shop_product_rubric_id');
	}
}
