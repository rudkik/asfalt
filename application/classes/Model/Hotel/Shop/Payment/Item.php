<?php defined('SYSPATH') or die('No direct script access.');


class Model_Hotel_Shop_Payment_Item extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'hc_shop_payment_items';
	const TABLE_ID = 144;

	public function __construct(){
		parent::__construct(
			array(
                'shop_client_id',
                'shop_payment_id',
                'shop_room_id',
                'amount',
                'price',
                'price_child',
                'human_extra',
                'child_extra',
                'price_extra',
                'date_from',
                'date_to',
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
                    case 'shop_payment_id':
                        $this->_dbGetElement($this->getShopPaymentID(), 'shop_payment_id', new Model_Hotel_Shop_Payment());
                        break;
                    case 'shop_room_id':
                        $this->_dbGetElement($this->getShopRoomID(), 'shop_room_id', new Model_Hotel_Shop_Room());
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
            ->rule('shop_payment_id', 'max_length', array(':value', 11))
            ->rule('shop_room_id', 'max_length', array(':value', 11))
            ->rule('amount', 'max_length', array(':value', 12))
            ->rule('price', 'max_length', array(':value', 12))
            ->rule('price_child', 'max_length', array(':value', 12))
            ->rule('human_extra', 'max_length', array(':value', 11))
            ->rule('child_extra', 'max_length', array(':value', 11))
            ->rule('price_extra', 'max_length', array(':value', 12));

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopClientID($value){
        $this->setValueInt('shop_client_id', $value);
    }
    public function getShopClientID(){
        return $this->getValueInt('shop_client_id');
    }

    public function setShopPaymentID($value){
        $this->setValueInt('shop_payment_id', $value);
    }
    public function getShopPaymentID(){
        return $this->getValueInt('shop_payment_id');
    }

    public function setShopRoomID($value){
        $this->setValueInt('shop_room_id', $value);
    }
    public function getShopRoomID(){
        return $this->getValueInt('shop_room_id');
    }

    public function setDateFrom($value){
        $this->setValueDate('date_from', $value);
    }
    public function getDateFrom(){
        return $this->getValueDateTime('date_from');
    }

    public function setDateTo($value){
        $this->setValueDate('date_to', $value);
    }
    public function getDateTo(){
        return $this->getValueDateTime('date_to');
    }

    public function setAmount($value){
        $this->setValueFloat('amount', $value);
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }

    public function setHumanExtra($value){
        $this->setValueInt('human_extra', $value);
    }
    public function getHumanExtra(){
        return $this->getValueInt('human_extra');
    }

    public function setPrice($value){
        $this->setValueFloat('price', $value);
    }
    public function getPrice(){
        return $this->getValueFloat('price');
    }

    public function setPriceExtra($value){
        $this->setValueFloat('price_extra', $value);
    }
    public function getPriceExtra(){
        return $this->getValueFloat('price_extra');
    }

    public function setPriceChild($value){
        $this->setValueFloat('price_child', $value);
    }
    public function getPriceChild(){
        return $this->getValueFloat('price_child');
    }

    public function setChildExtra($value){
        $this->setValueInt('child_extra', $value);
    }
    public function getChildExtra(){
        return $this->getValueInt('child_extra');
    }
}
