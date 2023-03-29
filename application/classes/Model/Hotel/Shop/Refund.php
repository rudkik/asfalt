<?php defined('SYSPATH') or die('No direct script access.');


class Model_Hotel_Shop_Refund extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'hc_shop_refunds';
	const TABLE_ID = 185;

	public function __construct(){
		parent::__construct(
			array(
                'shop_client_id',
                'refund_type_id',
                'amount',
                'date',
                'number',
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
                    case 'refund_type_id':
                        $this->_dbGetElement($this->getRefundTypeID(), 'refund_type_id', new Model_Hotel_RefundType());
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
            ->rule('amount', 'max_length', array(':value', 12));

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopClientID($value){
        $this->setValueInt('shop_client_id', $value);
    }
    public function getShopClientID(){
        return $this->getValueInt('shop_client_id');
    }

    public function setRefundTypeID($value){
        $this->setValueInt('refund_type_id', $value);
    }
    public function getRefundTypeID(){
        return $this->getValueInt('refund_type_id');
    }

    public function setAmount($value){
        $this->setValueFloat('amount', $value);
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }

    public function setDate($value){
        $this->setValue('date', $value);
    }
    public function getDate(){
        return $this->getValue('date');
    }

    public function setNumber($value){
        $this->setValue('number', $value);
    }
    public function getNumber(){
        return $this->getValue('number');
    }
}
