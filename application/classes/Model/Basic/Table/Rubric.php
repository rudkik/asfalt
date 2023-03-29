<?php defined('SYSPATH') or die('No direct script access.');


class Model_Basic_Table_Rubric extends Model_Basic_Table_Object{

	public function __construct(array $overallLanguageFields, $tableName, $tableID, $isTranslate = TRUE){
		$overallLanguageFields[] = 'shop_table_rubric_id';

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
		$this->setValue('shop_table_rubric_id', intval($value));
	}
	
	public function getShopTableRubricID(){
		return intval($this->getValue('shop_table_rubric_id'));
	}
}
