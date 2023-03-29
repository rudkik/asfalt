<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ads_Shop_Invoice extends Model_Shop_Basic_Options{

	const TABLE_NAME = 'ads_shop_invoices';
	const TABLE_ID = 183;

	public function __construct(){
		parent::__construct(
			array(
                'amount',
                'shop_client_id',
                'shop_parcel_id',
                'date_paid',
                'is_paid',
            ),
			self::TABLE_NAME,
			self::TABLE_ID
		);
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
            ->rule('shop_client_id', 'max_length', array(':value', 11))
            ->rule('shop_parcel_id', 'max_length', array(':value', 11))
            ->rule('is_paid', 'max_length', array(':value', 1));

        return $this->_validationFields($validation, $errorFields);
    }

    public function setAmount($value){
        $this->setValueFloat('amount', $value);
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }

    public function setShopParcelID($value){
        $this->setValue('shop_parcel_id', $value);
    }
    public function getShopParcelID(){
        return $this->getValue('shop_parcel_id');
    }

    public function setShopClientID($value){
        $this->setValue('shop_client_id', $value);
    }
    public function getShopClientID(){
        return $this->getValue('shop_client_id');
    }

    public function setDatePaid($value){
        $this->setValueDateTime('date_paid', $value);
    }
    public function getDatePaidt(){
        return $this->getValueDateTime('date_paid');
    }

    public function setIsPaid($value){
        $this->setValue('is_paid', $value);
    }
    public function getIsPaid(){
        return $this->getValue('is_paid');
    }
}
