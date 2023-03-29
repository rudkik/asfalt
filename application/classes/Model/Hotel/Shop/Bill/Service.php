<?php defined('SYSPATH') or die('No direct script access.');


class Model_Hotel_Shop_Bill_Service extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'hc_shop_bill_services';
	const TABLE_ID = 158;

	public function __construct(){
		parent::__construct(
			array(
                'shop_client_id',
                'shop_bill_id',
                'shop_service_id',
                'amount',
                'price',
                'quantity',
                'date',
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
                    case 'shop_service_id':
                        $this->_dbGetElement($this->getShopServiceID(), 'shop_service_id', new Model_Hotel_Shop_Service());
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
            ->rule('shop_service_id', 'max_length', array(':value', 11))
            ->rule('amount', 'max_length', array(':value', 12))
            ->rule('price', 'max_length', array(':value', 12))
            ->rule('quantity', 'max_length', array(':value', 12));

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopClientID($value){
        $this->setValueInt('shop_client_id', $value);
    }
    public function getShopClientID(){
        return $this->getValueInt('shop_client_id');
    }

    public function setShopBillID($value){
        $this->setValueInt('shop_bill_id', $value);
    }
    public function getShopBillID(){
        return $this->getValueInt('shop_bill_id');
    }

    public function setShopServiceID($value){
        $this->setValueInt('shop_service_id', $value);
    }
    public function getShopServiceID(){
        return $this->getValueInt('shop_service_id');
    }

    public function setAmount($value){
        $this->setValueFloat('amount', $value);
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }

    public function setQuantity($value){
        $this->setValueInt('quantity', $value);
    }
    public function getQuantity(){
        return $this->getValueInt('quantity');
    }

    public function setDate($value){
        $this->setValueDate('date', $value);
    }
    public function getDate(){
        return $this->getValueDateTime('date');
    }

    public function setPrice($value){
        $this->setValueFloat('price', $value);
    }
    public function getPrice(){
        return $this->getValueFloat('price');
    }
}
