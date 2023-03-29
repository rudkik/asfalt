<?php defined('SYSPATH') or die('No direct script access.');


class Model_Hotel_Shop_Payment extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'hc_shop_payments';
	const TABLE_ID = 154;

	public function __construct(){
		parent::__construct(
			array(
                'shop_client_id',
                'amount',
                'percent',
                'is_paid',
                'paid_at',
                'shop_paid_type_id',
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
                        $this->_dbGetElement($this->getShopClientID(), 'shop_client_id', new Model_Hotel_Shop_Client());
                        break;
                    case 'shop_bill_id':
                        $this->_dbGetElement($this->getShopBillID(), 'shop_bill_id', new Model_Hotel_Shop_Bill());
                        break;
                    case 'shop_paid_type_id':
                        $this->_dbGetElement($this->getShopPaidTypeID(), 'shop_paid_type_id', new Model_Shop_PaidType(), $shopID);
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
        $validation->rule('shop_client_id', 'max_length', array(':value', 11))
            ->rule('shop_bill_id', 'max_length', array(':value', 11))
            ->rule('shop_paid_type_id', 'max_length', array(':value', 11))
            ->rule('amount', 'max_length', array(':value', 12))
            ->rule('is_paid', 'max_length', array(':value', 1));

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopBillID($value){
        $this->setValueInt('shop_bill_id', $value);
    }
    public function getShopBillID(){
        return $this->getValueInt('shop_bill_id');
    }

    public function setShopClientID($value){
        $this->setValueInt('shop_client_id', $value);
    }
    public function getShopClientID(){
        return $this->getValueInt('shop_client_id');
    }

    public function setShopPaidTypeID($value){
        $this->setValueInt('shop_paid_type_id', $value);
    }
    public function getShopPaidTypeID(){
        return $this->getValueInt('shop_paid_type_id');
    }

    public function setAmount($value){
        $this->setValueFloat('amount', $value);
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }

    public function setPercent($value){
        if ($value < 0){
            $value = 0;
        }elseif ($value > 100){
            $value = 100;
        }
        $this->setValueFloat('percent', $value);
    }
    public function getPercent(){
        return $this->getValueFloat('percent');
    }

    public function setNumber($value){
        $this->setValue('number', $value);
    }
    public function getNumber(){
        return $this->getValue('number');
    }

    public function setIsPaid($value){
        $this->setValueBool('is_paid', $value);

        if($this->getIsPaid()){
            if (Func::_empty($this->getPaidAt())){
                $this->setPaidAt(date('Y-m-d H:i:s'));
            }
        }else{
            $this->setPaidAt(NULL);
        }
    }
    public function getIsPaid(){
        return $this->getValueBool('is_paid');
    }

    public function setPaidAt($value){
        $this->setValue('paid_at', $value);
    }
    public function getPaidAt(){
        return $this->getValue('paid_at');
    }
}
