<?php defined('SYSPATH') or die('No direct script access.');

class Model_Shop_Operation_Stock extends Model_Shop_Basic_Options{

	const TABLE_NAME = 'ct_shop_operation_stocks';
	const TABLE_ID = 74;

	public function __construct(){
		parent::__construct(
			array(
				'shop_table_catalog_id',
                'amount',
                'amount_first',
				'is_close',
                'shop_operation_id',
			),
			self::TABLE_NAME,
			self::TABLE_ID,
			FALSE
		);

        $this->isAddCreated = TRUE;
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
                    case 'shop_table_catalog_id':
                        $this->_dbGetElement($this->getShopTableCatalogID(), 'shop_table_catalog_id', new Model_Shop_Table_Catalog(), $shopID);
                        break;
                    case 'shop_operation_id':
                        $this->_dbGetElement($this->getShopOperationID(), 'shop_operation_id', new Model_Shop_Operation(), $shopID);
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

        $validation->rule('shop_operation_id', 'max_length', array(':value', 11))
            ->rule('shop_table_catalog_id', 'max_length', array(':value', 11))
            ->rule('is_close', 'max_length', array(':value', 1))
            ->rule('is_close', 'range', array(':value', 0, 1));


        if ($this->isFindFieldAndIsEdit('shop_operation_id')) {
            $validation->rule('shop_operation_id', 'digit');
        }
        if ($this->isFindFieldAndIsEdit('shop_table_catalog_id')) {
            $validation->rule('shop_table_catalog_id', 'digit');
        }
        if ($this->isFindFieldAndIsEdit('is_close')) {
            $validation->rule('is_close', 'digit');
        }

        return $this->_validationFields($validation, $errorFields);
    }

    /**
     * сохранение записи в базу данных
     * @param int $languageID
     * @param int $userID
     * @param int $shopID
     * @return mixed
     * @throws Kohana_Kohana_Exception
     */
    public function dbSave($languageID = 0, $userID = 0, $shopID = 0)
    {
        if ($this->isEdit()) {
            $this->_preDBSave(0, $userID, $shopID);
            
            $this->_isDBDriver();
            $this->id = $this->getDBDriver()->saveObject($this, 0, $this->shopID);
        }

        return $this->id;
    }

    public function setShopTableCatalogID($value){
        $this->setValueInt('shop_table_catalog_id', $value);
    }
    public function getShopTableCatalogID(){
        return $this->getValueInt('shop_table_catalog_id');
    }

    public function setShopOperationID($value){
        $this->setValueInt('shop_operation_id', $value);
    }
    public function getShopOperationID(){
        return $this->getValueInt('shop_operation_id');
    }

    public function setIsClose($value){
        $this->setValueBool('is_close', $value);
    }
    public function getIsClose(){
        return $this->getValueBool('is_close');
    }

    public function setAmount($value){
        $this->setValueFloat('amount', $value);
        if ($this->getAmountFirst() <= 0){
            $this->setAmountFirst($value);
        }
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }

    public function setAmountFirst($value){
        $this->setValueFloat('amount_first', $value);
    }
    public function getAmountFirst(){
        return $this->getValueFloat('amount_first');
    }
}
