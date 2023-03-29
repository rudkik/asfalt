<?php defined('SYSPATH') or die('No direct script access.');


class Model_Shop_Table_Basic_Rubric extends Model_Shop_Table_Basic_Object{

	public function __construct(array $overallLanguageFields, $tableName, $tableID, $isTranslate = TRUE){
		$overallLanguageFields[] = 'shop_table_rubric_id';
        $overallLanguageFields[] = 'shop_table_rubric_ids';

		parent::__construct($overallLanguageFields, $tableName, $tableID, $isTranslate);
	}

    public function dbGetElements($shopID = 0, $elements = NULL){
		if(($elements === NULL) || (! is_array($elements))){
		}else{
			foreach($elements as $element){
				switch($element){
					case 'shop_table_rubric_id':
						$this->_dbGetElement($this->getShopTableRubricID(), 'shop_table_rubric_id', new Model_Shop_Table_Rubric(), $shopID);
						break;
				}
			}
		}

		parent::dbGetElements($shopID, $elements);
	}

    /**
     * Возвращаем cписок всех переменных
     */
    public function getValues($isGetElement = FALSE, $isParseArray = FALSE, $shopID = NULL)
    {
        $arr = parent::getValues($isGetElement, $isParseArray, $shopID);

        if($isParseArray === TRUE) {
            $arr['shop_table_rubric_ids'] = $this->getShopTableRubricIDsArray();
        }

        return $arr;
    }

	/**
	 * Проверяем поля на ошибки
	 * @param array $errorFields - массив ошибок
	 * @return boolean
	 */
	public function validationFields(array &$errorFields){
		$validation = new Validation($this->getValues());

		$validation->rule('shop_table_rubric_id', 'max_length', array(':value', 11))
			->rule('table_id', 'max_length', array(':value', 11));

		if ($this->isFindFieldAndIsEdit('shop_table_rubric_id')){
			$validation->rule('shop_table_rubric_id', 'digit');
		}

		return $this->_validationFields($validation, $errorFields);
	}

	// ID рубрики
	public function setShopTableRubricID($value){
	    if($value != $this->getShopTableRubricID()){
            unset($this->_elements['shop_table_rubric_id']);
        }
		$this->setValueInt('shop_table_rubric_id', $value);
	}
	public function getShopTableRubricID(){
		return $this->getValueInt('shop_table_rubric_id');
	}

    public function setShopTableRubricIDsArray(array $value){
        $this->setValueArray('shop_table_rubric_ids', $value);
    }
    public function getShopTableRubricIDsArray(){
        return $this->getValueArray('shop_table_rubric_ids');
    }
}
