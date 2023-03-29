<?php defined('SYSPATH') or die('No direct script access.');

class Model_Shop_Operation_Stock_Item extends Model_Shop_Basic_Options{
	
	const TABLE_NAME='ct_shop_operation_stock_items';
	const TABLE_ID = 75;

	public function __construct()
	{
		parent::__construct(
			array(
				'shop_table_catalog_id',
                'shop_operation_stock_id',
                'shop_operation_id',
				'shop_good_id',
				'shop_table_child_id',
				'price',
				'count',
				'count_first',
				'amount',
			),
			self::TABLE_NAME,
			self::TABLE_ID,
			FALSE
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
                    case 'shop_good_id':
                        $this->_dbGetElement($this->getShopGoodID(), 'shop_good_id', new Model_Shop_Good(), $this->shopID);
                        break;
                    case 'shop_operation_stock_id':
                        $this->_dbGetElement($this->getShopOperationStockID(), 'shop_operation_stock_id', new Model_Shop_Operation_Stock(), $this->shopID);
                        break;
                    case 'shop_operation_id':
                        $this->_dbGetElement($this->getShopOperationID(), 'shop_operation_id', new Model_Shop_Operation(), $shopID);
                        break;
					case 'shop_table_child_id':
						$this->_dbGetElement($this->getShopTableChildID(), 'shop_table_child_id', new Model_Shop_Table_Child(), $this->shopID);
						break;
                    case 'shop_table_catalog_id':
                        $this->_dbGetElement($this->getShopTableCatalogID(), 'shop_table_catalog_id', new Model_Shop_Table_Catalog(), $shopID);
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

        $validation->rule('shop_good_id', 'max_length', array(':value', 11))
            ->rule('shop_operation_stock_id', 'max_length', array(':value', 11))
            ->rule('shop_operation_id', 'max_length', array(':value', 11))
            ->rule('shop_table_child_id', 'max_length', array(':value', 11))
            ->rule('count', 'max_length', array(':value', 14))
            ->rule('amount', 'max_length', array(':value', 14))
            ->rule('count_first', 'max_length', array(':value', 14));

        if ($this->isFindFieldAndIsEdit('shop_table_child_id')) {
            $validation->rule('shop_table_child_id', 'digit');
        }
        if ($this->isFindFieldAndIsEdit('shop_operation_stock_id')) {
            $validation->rule('shop_operation_stock_id', 'digit');
        }
        if ($this->isFindFieldAndIsEdit('shop_good_id')) {
            $validation->rule('shop_good_id', 'digit');
        }
        if ($this->isFindFieldAndIsEdit('shop_operation_id')) {
            $validation->rule('shop_operation_id', 'digit');
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
        $this->_preDBSave(0, $userID, $shopID);

        if ($this->isEdit()) {
            $this->_isDBDriver();
            $this->id = $this->getDBDriver()->saveObject($this, 0, $this->shopID);
        }

        return $this->id;
    }

    // ID склада
    public function setShopOperationStockID($value){
        $this->setValueInt('shop_operation_stock_id', $value);
    }
    public function getShopOperationStockID(){
        return $this->getValueInt('shop_operation_stock_id');
    }

    public function setShopOperationID($value){
        $this->setValueInt('shop_operation_id', $value);
    }
    public function getShopOperationID(){
        return $this->getValueInt('shop_operation_id');
    }

    // ID товара
    public function setShopGoodID($value){
        $this->setValueInt('shop_good_id', $value);
    }
    public function getShopGoodID(){
        return $this->getValueInt('shop_good_id');
    }

    // ID подтовара
    public function setShopTableChildID($value){
        $this->setValueInt('shop_table_child_id', $value);
    }
    public function getShopTableChildID(){
        return $this->getValueInt('shop_table_child_id');
    }

    public function setShopTableCatalogID($value){
        $this->setValueInt('shop_table_catalog_id', $value);
    }
    public function getShopTableCatalogID(){
        return $this->getValueInt('shop_table_catalog_id');
    }

    // Цена
    public function setPrice($value){
        $this->setValueFloat('price', $value);
    }
    public function getPrice(){
        return $this->getValueFloat('price');
    }

    // Количество
    public function setCountElement($value, $isRecountAmount = FALSE){
        if(($this->id < 1) || ($this->getCountFist() < 1)){
            $this->setCountFirst($value);
        }

        $this->setValueFloat('count', $value);

        if($isRecountAmount === TRUE){
            $this->setAmount($this->getCountElement() * $this->getPrice());
        }
    }
    public function getCountElement(){
        return $this->getValueFloat('count');
    }

    // Первоначальное количество
    public function setCountFirst($value){
        $this->setValueFloat('count_first', $value);
    }
    public function getCountFist(){
        return $this->getValueFloat('count_first');
    }

    // Стоимость букетов
    public function setAmount($value){
        $this->setValueFloat('amount', $value);
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }
}
