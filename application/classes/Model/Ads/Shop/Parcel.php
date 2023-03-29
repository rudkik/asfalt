<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ads_Shop_Parcel extends Model_Shop_Basic_Options{

	const TABLE_NAME = 'ads_shop_parcels';
	const TABLE_ID = 181;

	public function __construct(){
		parent::__construct(
			array(
                'amount',
                'invoice_amount',
                'paid_amount',
                'tracker',
                'price',
                'parcel_status_id',
                'weight',
                'date_receipt_at',
                'shop_name',
                'date_send',
                'address',
                'tracker_send',
                'shop_client_id',
                'delivery_type_id',
                'warehouse_id',
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
                    case 'shop_client_id':
                        $this->_dbGetElement($this->getShopClientID(), 'shop_client_id', new Model_Ads_Shop_Client());
                        break;
                    case 'parcel_status_id':
                        $this->_dbGetElement($this->getParcelStatusID(), 'parcel_status_id', new Model_Ads_ParcelStatus());
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
        $validation->rule('amount', 'max_length', array(':value', 12))
            ->rule('paid_amount', 'max_length', array(':value', 12))
            ->rule('invoice_amount', 'max_length', array(':value', 12))
            ->rule('tracker', 'max_length', array(':value', 50))
            ->rule('price', 'max_length', array(':value', 12))
            ->rule('parcel_status_id', 'max_length', array(':value', 11))
            ->rule('delivery_type_id', 'max_length', array(':value', 11))
            ->rule('shop_client_id', 'max_length', array(':value', 11))
            ->rule('weight', 'max_length', array(':value', 12))
            ->rule('shop_name', 'max_length', array(':value', 100))
            ->rule('delivery_amount', 'max_length', array(':value', 12))
            ->rule('address', 'max_length', array(':value', 65000))
            ->rule('tracker_send', 'max_length', array(':value', 500))
            ->rule('warehouse_id', 'max_length', array(':value', 11));

        return $this->_validationFields($validation, $errorFields);
    }

    public function setDeliveryTypeID($value){
        $this->setValue('delivery_type_id', $value);
    }
    public function getDeliveryTypeID(){
        return $this->getValue('delivery_type_id');
    }

    public function setAmount($value){
        $this->setValueFloat('amount', $value);
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }

    public function setPaidAmount($value){
        $this->setValueFloat('paid_amount', $value);
    }
    public function getPaidAmount(){
        return $this->getValueFloat('paid_amount');
    }

    public function setInvoiceAmount($value){
        $this->setValueFloat('invoice_amount', $value);
    }
    public function getInvoiceAmount(){
        return $this->getValueFloat('invoice_amount');
    }

    public function setTracker($value){
        $this->setValue('tracker', $value);
    }
    public function getTracker(){
        return $this->getValue('tracker');
    }

    public function setPrice($value){
        $this->setValueFloat('price', $value);
    }
    public function getPrice(){
        return $this->getValueFloat('price');
    }

    public function setParcelStatusID($value){
        $this->setValue('parcel_status_id', $value);
    }
    public function getParcelStatusID(){
        return $this->getValue('parcel_status_id');
    }

    public function setShopClientID($value){
        $this->setValue('shop_client_id', $value);
    }
    public function getShopClientID(){
        return $this->getValue('shop_client_id');
    }

    public function setWeight($value){
        $this->setValueFloat('weight', $value);
    }
    public function getWeight(){
        return $this->getValueFloat('weight');
    }

    public function setDateReceiptAt($value){
        $this->setValueDateTime('date_receipt_at', $value);
    }
    public function getDateReceiptAt(){
        return $this->getValueDateTime('date_receipt_at');
    }

    public function setShopName($value){
        $this->setValue('shop_name', $value);
    }
    public function getShopName(){
        return $this->getValue('shop_name');
    }

    public function setDateSend($value){
        $this->setValueDateTime('date_send', $value);
    }
    public function getDateSend(){
        return $this->getValueDateTime('date_send');
    }

    public function setAddress($value){
        $this->setValue('address', $value);
    }
    public function getAddress(){
        return $this->getValue('address');
    }

    public function setTrackerSend($value){
        $this->setValue('tracker_send', $value);
    }
    public function getTrackerSend(){
        return $this->getValue('tracker_send');
    }

    public function setWarehouseID($value){
        $this->setValue('warehouse_id', $value);
    }
    public function getWarehouseID(){
        return $this->getValue('warehouse_id');
    }

    public function setWarehouseWeight($value){
        $this->setValueFloat('warehouse_weight', $value);
    }
    public function getWarehouseWeight(){
        return $this->getValueFloat('warehouse_weight');
    }
}
