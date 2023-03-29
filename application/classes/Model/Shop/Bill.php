<?php defined('SYSPATH') or die('No direct script access.');

class Model_Shop_Bill extends Model_Shop_Basic_Bill{

	const TABLE_NAME = 'ct_shop_bills';
	const TABLE_ID = 52;

	public function __construct(){
		parent::__construct(
			array(
				'shop_table_catalog_id',
				'shop_bill_status_id',
				'bill_status_id',
				'shop_delivery_type_id',
				'shop_coupon_id',
				'shop_root_id',
				'country_id',
				'city_id',
				'shop_bill_root_id',
				'currency_id',
				'is_delivery',
				'delivery_at',
				'delivery_amount',
				'discount',
				'is_percent',
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
                    case 'bill_status_id':
                        $this->_dbGetElement($this->getBillStatusID(), 'bill_status_id', new Model_BillStatus());
                        break;
                    case 'shop_bill_status_id':
                        $this->_dbGetElement($this->getShopBillStatusID(), 'shop_bill_status_id', new Model_Shop_Bill_Status(), $shopID);
                        break;
					case 'city_id':
						$this->_dbGetElement($this->getCityID(), 'city_id', new Model_City());
						break;
					case 'country_id':
						$this->_dbGetElement($this->getCountryID(), 'country_id', new Model_Land());
						break;
					case 'shop_coupon_id':
						$this->_dbGetElement($this->getShopCouponID(), 'shop_coupon_id', new Model_Shop_Coupon());
						break;
					case 'shop_delivery_type_id':
						$this->_dbGetElement($this->getShopDeliveryTypeID(), 'shop_delivery_type_id', new Model_Shop_DeliveryType(), $shopID);
						break;
					case 'shop_root_id':
						$this->_dbGetElement($this->getShopRootID(), 'shop_root_id', new Model_Shop());
						break;
					case 'shop_table_catalog_id':
						$this->_dbGetElement($this->getShopTableCatalogID(), 'shop_table_catalog_id', new Model_Shop_Table_Catalog(), $shopID);
						break;
                    case 'shop_bill_root_id':
						$this->_dbGetElement($this->getShopBillRootID(), 'shop_bill_root_id', new Model_Shop_Bill());
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

        $validation->rule('bill_status_id', 'max_length', array(':value', 11))
            ->rule('shop_bill_status_id', 'max_length', array(':value', 11))
            ->rule('shop_table_catalog_id', 'max_length', array(':value', 11))
            ->rule('currency_id', 'max_length', array(':value', 11))
            ->rule('shop_delivery_type_id', 'max_length', array(':value', 11))
            ->rule('shop_coupon_id', 'max_length', array(':value', 11))
            ->rule('is_delivery', 'max_length', array(':value', 1))
            ->rule('is_delivery', 'range', array(':value', 0, 1))
            ->rule('is_percent', 'max_length', array(':value', 1))
            ->rule('is_percent', 'range', array(':value', 0, 1))
            ->rule('shop_comment', 'max_length', array(':value', 650000))
            ->rule('options', 'max_length', array(':value', 650000))
            ->rule('shop_root_id', 'max_length', array(':value', 11))
            ->rule('country_id', 'max_length', array(':value', 11))
            ->rule('city_id', 'max_length', array(':value', 11))
            ->rule('shop_bill_root_id', 'max_length', array(':value', 11))
            ->rule('client_comment', 'max_length', array(':value', 650000))
            ->rule('cancel_comment', 'max_length', array(':value', 650000));

        if ($this->isFindFieldAndIsEdit('delivery_at')) {
            $validation->rule('delivery_at', 'date');
        }
        if ($this->isFindFieldAndIsEdit('is_delivery')) {
            $validation->rule('is_delivery', 'digit');
        }
        if ($this->isFindFieldAndIsEdit('shop_coupon_id')) {
            $validation->rule('shop_coupon_id', 'digit');
        }
        if ($this->isFindFieldAndIsEdit('bill_status_id')) {
            $validation->rule('bill_status_id', 'digit');
        }
        if ($this->isFindFieldAndIsEdit('shop_bill_status_id')) {
            $validation->rule('shop_bill_status_id', 'digit');
        }
        if ($this->isFindFieldAndIsEdit('shop_table_catalog_id')) {
            $validation->rule('shop_table_catalog_id', 'digit');
        }
        if ($this->isFindFieldAndIsEdit('is_percent')) {
            $validation->rule('is_percent', 'digit');
        }
        if ($this->isFindFieldAndIsEdit('currency_id')) {
            $validation->rule('currency_id', 'digit');
        }
        if ($this->isFindFieldAndIsEdit('shop_delivery_type_id')) {
            $validation->rule('shop_delivery_type_id', 'digit');
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
        if ($this->isFindFieldAndIsEdit('shop_bill_root_id')) {
            $validation->rule('shop_bill_root_id', 'digit');
        }

        return $this->_validationFields($validation, $errorFields);
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

    // статус заказа
    public function setBillStatusID($value){
        $this->setValueInt('bill_status_id', $value);
    }
    public function getBillStatusID(){
        return $this->getValueInt('bill_status_id');
    }
    public function setShopBillStatusID($value){
        $this->setValueInt('shop_bill_status_id', $value);
    }
    public function getShopBillStatusID(){
        return $this->getValueInt('shop_bill_status_id');
    }

    // Тип доставки заказа
    public function setShopDeliveryTypeID($value){
        $this->setValueInt('shop_delivery_type_id', $value);
    }
    public function getShopDeliveryTypeID(){
        return $this->getValueInt('shop_delivery_type_id');
    }

    // ID купона
    public function setShopCouponID($value){
        $this->setValueInt('shop_coupon_id', $value);
    }
    public function getShopCouponID(){
        return $this->getValueInt('shop_coupon_id');
    }

    // ID главного заказа
    public function setShopBillRootID($value){
        $this->setValueInt('shop_bill_root_id', $value);
    }
    public function getShopBillRootID(){
        return $this->getValueInt('shop_bill_root_id');
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

    // Доставлен ли заказ
    public function setIsDelivery($value){
        $this->setValueBool('is_delivery', $value);
    }
    public function getIsDelivery(){
        return $this->getValueBool('is_delivery');
    }

    // Дата доставки заказа
    public function setDeliveryAt($value){
        $this->setValueDateTime('delivery_at', $value);
    }
    public function getDeliveryAt(){
        return $this->getValue('delivery_at');
    }

    // Стоимость доставки
    public function setDeliveryAmount($value){
        $this->setValueFloat('delivery_amount', $value);
    }
    public function getDeliveryAmount(){
        return $this->getValueFloat('delivery_amount');
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

    public function setCancelComment($value){
        $this->setValue('cancel_comment', $value);
    }
    public function getCancelComment(){
        return $this->getValue('cancel_comment');
    }

    public function setAddress($value){
        $this->setValue('address', $value);
    }
    public function getAddress(){
        return $this->getValue('address');
    }
}
