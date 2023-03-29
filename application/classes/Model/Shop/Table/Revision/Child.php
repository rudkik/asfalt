<?php defined('SYSPATH') or die('No direct script access.');

class Model_Shop_Table_Revision_Child extends Model_Shop_Table_ObjectToObject{

	const TABLE_NAME='ct_shop_table_revision_childs';
	const TABLE_ID = 93;

	public function __construct(){
		parent::__construct();

        $overallLanguageFields[] = 'old_shop_table_stock_id';
        $overallLanguageFields[] = 'new_shop_table_stock_id';

        $this->tableName = self::TABLE_NAME;
        $this->tableID = self::TABLE_ID;
	}

	/**
	 * Проверяем поля на ошибки
	 * @param array $errorFields - массив ошибок
	 * @return boolean
	 */
	public function validationFields(array &$errorFields){
		$validation = new Validation($this->getValues());
	
		$validation->rule('old_shop_table_stock_id', 'max_length', array(':value', 11))
			->rule('new_shop_table_stock_id', 'max_length', array(':value', 11));

		if ($this->isFindFieldAndIsEdit('old_shop_table_stock_id')){
			$validation->rule('old_shop_table_stock_id', 'digit');
		}

		if ($this->isFindFieldAndIsEdit('new_shop_table_stock_id')){
			$validation->rule('new_shop_table_stock_id', 'digit');
		}
	
		return $this->_validationFields($validation, $errorFields);
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
                    case 'old_shop_table_stock_id':
                        $this->_dbGetElement($this->getOldShopTableStockID(), 'old_shop_table_stock_id', new Model_Shop_Table_Stock());
                        break;
                    case 'new_shop_table_stock_id':
                        $this->_dbGetElement($this->getNewShopTableStockID(), 'new_shop_table_stock_id', new Model_Shop_Table_Stock());
                        break;
				}
			}
		}

		parent::dbGetElements($shopID, $elements);
	}

    //
    public function setOldShopTableStockID($value){
        $this->setValueInt('old_shop_table_stock_id', $value);
    }
    public function getOldShopTableStockID(){
        return $this->getValueInt('old_shop_table_stock_id');
    }

    public function setNewShopTableStockID($value){
        $this->setValueInt('new_shop_table_stock_id', $value);
    }
    public function getNewShopTableStockID(){
        return $this->getValueInt('new_shop_table_stock_id');
    }
}
