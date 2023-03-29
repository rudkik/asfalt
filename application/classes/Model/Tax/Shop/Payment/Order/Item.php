<?php defined('SYSPATH') or die('No direct script access.');


class Model_Tax_Shop_Payment_Order_Item extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'tax_shop_payment_order_items';
	const TABLE_ID = 134;

	public function __construct(){
		parent::__construct(
			array(
                'shop_contractor_id',
                'shop_payment_order_id',
                'shop_worker_id',
                'amount',
                'date',
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
        $validation->rule('shop_contractor_id', 'max_length', array(':value', 11))
            ->rule('shop_payment_order_id', 'max_length', array(':value', 11))
            ->rule('shop_worker_id', 'max_length', array(':value', 11))
            ->rule('amount', 'max_length', array(':value', 12));

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopContractorID($value){
        $this->setValueInt('shop_contractor_id', $value);
    }
    public function getShopContractorID(){
        return $this->getValueInt('shop_contractor_id');
    }

    public function setShopWorkerID($value){
        $this->setValueInt('shop_worker_id', $value);
    }
    public function getShopWorkerID(){
        return $this->getValueInt('shop_worker_id');
    }

    public function setShopPaymentOrderID($value){
        $this->setValueInt('shop_payment_order_id', $value);
    }
    public function getShopPaymentOrderID(){
        return $this->getValueInt('shop_payment_order_id');
    }

    public function setAmount($value){
        $this->setValueFloat('amount', $value);
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }

    public function setDate($value){
        $this->setValueDate('date', $value);
    }
    public function getDate(){
        return $this->getValueDateTime('date');
    }
    public function setDateInt($value){
        if (strlen($value) == 6){
            $this->setValueDate('date', substr($value, 2) . '-'.substr($value, 0, 2).'-01');
        }
    }
}
