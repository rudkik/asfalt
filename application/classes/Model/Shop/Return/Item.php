<?php defined('SYSPATH') or die('No direct script access.');

class Model_Shop_Return_Item extends Model_Shop_Basic_Options{
	
	const TABLE_NAME='ct_shop_return_items';
	const TABLE_ID = 73;

	public function __construct()
	{
		parent::__construct(
			array(
				'shop_table_catalog_id',
				'shop_return_id',
				'shop_good_id',
				'shop_table_child_id',
				'price',
				'count',
				'amount',
				'discount',
				'is_percent',
				'is_add_action',
				'client_comment',
                'shop_discount_id',
                'shop_root_id',
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
                    case 'shop_root_id':
                        $this->_dbGetElement($this->getShopRootID(), 'shop_root_id', new Model_Shop());
                        break;
                    case 'shop_return_id':
                        $this->_dbGetElement($this->getShopReturnID(), 'shop_return_id', new Model_Shop_Return(), $this->shopID);
                        break;
                    case 'shop_discount_id':
                        $this->_dbGetElement($this->getShopDiscountID(), 'shop_discount_id', new Model_Shop_Discount());
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
            ->rule('shop_return_id', 'max_length', array(':value', 11))
            ->rule('shop_table_child_id', 'max_length', array(':value', 11))
            ->rule('is_percent', 'max_length', array(':value', 1))
            ->rule('client_comment', 'max_length', array(':value', 650000))
            ->rule('is_add_action', 'max_length', array(':value', 1))
            ->rule('count', 'max_length', array(':value', 14))
            ->rule('shop_root_id', 'max_length', array(':value', 11))
            ->rule('shop_discount_id', 'max_length', array(':value', 11));

        if ($this->isFindFieldAndIsEdit('shop_table_child_id')) {
            $validation->rule('shop_table_child_id', 'digit');
        }
        if ($this->isFindFieldAndIsEdit('shop_discount_id')) {
            $validation->rule('shop_discount_id', 'digit');
        }
        if ($this->isFindFieldAndIsEdit('shop_good_id')) {
            $validation->rule('shop_good_id', 'digit');
        }
        if ($this->isFindFieldAndIsEdit('shop_return_id')) {
            $validation->rule('shop_return_id', 'digit');
        }
        if ($this->isFindFieldAndIsEdit('is_percent')) {
            $validation->rule('is_percent', 'digit');
        }
        if ($this->isFindFieldAndIsEdit('is_add_action')) {
            $validation->rule('is_add_action', 'digit');
        }
        if ($this->isFindFieldAndIsEdit('shop_root_id')) {
            $validation->rule('shop_root_id', 'digit');
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

    public function setShopRootID($value){
        $this->setValueInt('shop_root_id', $value);
    }
    public function getShopRootID(){
        return $this->getValueInt('shop_root_id');
    }

    // Процент скидки
    public function setIsPercent($value){
        $this->setValueBool('is_percent', $value);
    }
    public function getIsPercent(){
        return $this->getValueBool('is_percent');
    }

    // добавленный товар по акции
    public function setIsAddAction($value){
        $this->setValueBool('is_add_action', $value);
    }
    public function getIsAddAction(){
        return $this->getValueBool('is_add_action');
    }

    // ID заказа
    public function setShopReturnID($value){
        $this->setValueInt('shop_return_id', $value);
    }
    public function getShopReturnID(){
        return $this->getValueInt('shop_return_id');
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

    // Комментарий клиента
    public function setClientComment($value){
        $this->setValue('client_comment', $value);
    }

    public function getClientComment(){
        return $this->getValue('client_comment');
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
        $this->setValueFloat('count', $value);

        if($isRecountAmount === TRUE){
            $this->setAmount($this->getCountElement() * $this->getPrice());
        }
    }
    public function getCountElement(){
        return $this->getValueFloat('count');
    }

    // Скидка на букеты
    public function setDiscount($value){
        $this->setValueFloat('discount', $value);
    }
    public function getDiscount(){
        return $this->getValueFloat('discount');
    }

    // Скидка на букеты
    public function setShopDiscountID($value){
        $this->setValueInt('shop_discount_id', $value);
    }
    public function getShopDiscountID(){
        return $this->getValueInt('shop_discount_id');
    }

    // Стоимость букетов
    public function setAmount($value){
        $this->setValueFloat('amount', $value);
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }
}
