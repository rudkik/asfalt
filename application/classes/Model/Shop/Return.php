<?php defined('SYSPATH') or die('No direct script access.');

class Model_Shop_Return extends Model_Shop_Basic_Options{

	const TABLE_NAME = 'ct_shop_returns';
	const TABLE_ID = 72;

	public function __construct(){
		parent::__construct(
			array(
				'shop_table_catalog_id',
				'shop_coupon_id',
				'shop_root_id',
				'country_id',
				'city_id',
				'shop_return_root_id',
				'currency_id',
				'amount',
				'shop_comment',
				'client_comment',
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
                    case 'shop_bill_id':
                        $this->_dbGetElement($this->getShopBillID(), 'shop_bill_id', new Model_Shop_Bill());
                        break;
					case 'city_id':
						$this->_dbGetElement($this->getCityID(), 'city_id', new Model_City());
						break;
					case 'country_id':
						$this->_dbGetElement($this->getCountryID(), 'country_id', new Model_Land());
						break;
					case 'shop_root_id':
						$this->_dbGetElement($this->getShopRootID(), 'shop_root_id', new Model_Shop());
						break;
					case 'shop_table_catalog_id':
						$this->_dbGetElement($this->getShopTableCatalogID(), 'shop_table_catalog_id', new Model_Shop_Table_Catalog(), $shopID);
						break;
                    case 'shop_return_root_id':
						$this->_dbGetElement($this->getShopReturnRootID(), 'shop_return_root_id', new Model_Shop_Return());
						break;
                    case 'currency_id':
						$this->_dbGetElement($this->getCurrencyID(), 'currency_id', new Model_Currency());
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

        $validation->rule('shop_bill_id', 'max_length', array(':value', 11))
            ->rule('shop_table_catalog_id', 'max_length', array(':value', 11))
            ->rule('currency_id', 'max_length', array(':value', 11))
            ->rule('shop_comment', 'max_length', array(':value', 650000))
            ->rule('options', 'max_length', array(':value', 650000))
            ->rule('shop_root_id', 'max_length', array(':value', 11))
            ->rule('country_id', 'max_length', array(':value', 11))
            ->rule('city_id', 'max_length', array(':value', 11))
            ->rule('shop_return_root_id', 'max_length', array(':value', 11))
            ->rule('client_comment', 'max_length', array(':value', 650000));

        if ($this->isFindFieldAndIsEdit('shop_bill_id')) {
            $validation->rule('shop_bill_id', 'digit');
        }
        if ($this->isFindFieldAndIsEdit('shop_table_catalog_id')) {
            $validation->rule('shop_table_catalog_id', 'digit');
        }
        if ($this->isFindFieldAndIsEdit('currency_id')) {
            $validation->rule('currency_id', 'digit');
        }
        if ($this->isFindFieldAndIsEdit('shop_root_id')) {
            $validation->rule('shop_root_id', 'digit');
        }
        if ($this->isFindFieldAndIsEdit('country_id')) {
            $validation->rule('country_id', 'digit');
        }
        if ($this->isFindFieldAndIsEdit('city_id')) {
            $validation->rule('city_id', 'digit');
        }
        if ($this->isFindFieldAndIsEdit('shop_return_root_id')) {
            $validation->rule('shop_return_root_id', 'digit');
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
            $this->id = $this->getDBDriver()->saveObject($this, 0, 0, $this->shopID);
        }

        return $this->id;
    }

    public function setCurrencyID($value){
        $this->setValueInt('currency_id', $value);
    }
    public function getCurrencyID(){
        return $this->getValueInt('currency_id');
    }

    public function setShopTableCatalogID($value){
        $this->setValueInt('shop_table_catalog_id', $value);
    }
    public function getShopTableCatalogID(){
        return $this->getValueInt('shop_table_catalog_id');
    }

    // Магазин создавший заказ
    public function setShopRootID($value){
        $this->setValueInt('shop_root_id', $value);
    }
    public function getShopRootID(){
        return $this->getValueInt('shop_root_id');
    }

    public function setShopBillID($value){
        $this->setValueInt('shop_bill_id', $value);
    }
    public function getShopBillID(){
        return $this->getValueInt('shop_bill_id');
    }

    // ID главного возврата
    public function setShopReturnRootID($value){
        $this->setValueInt('shop_return_root_id', $value);
    }
    public function getShopReturnRootID(){
        return $this->getValueInt('shop_return_root_id');
    }

    // ID города
    public function setCityID($value){
        $this->setValueInt('city_id', $value);
    }
    public function getCityID(){
        return $this->getValueInt('city_id');
    }

    // ID страны
    public function setCountryID($value){
        $this->setValueInt('country_id', $value);
    }
    public function getCountryID(){
        return $this->getValueInt('country_id');
    }

    // Стоимость
    public function setAmount($value){
        $this->setValueFloat('amount', $value);
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }

    // Комментарий магазина
    public function setShopComment($value){
        $this->setValue('shop_comment', $value);
    }
    public function getShopComment(){
        return $this->getValue('shop_comment');
    }

    public function setClientComment($value){
        $this->setValue('client_comment', $value);
    }
    public function getClientComment(){
        return $this->getValue('client_comment');
    }
}
