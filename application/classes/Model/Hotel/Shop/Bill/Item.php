<?php defined('SYSPATH') or die('No direct script access.');


class Model_Hotel_Shop_Bill_Item extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'hc_shop_bill_items';
	const TABLE_ID = 144;

	public function __construct(){
		parent::__construct(
			array(
                'shop_client_id',
                'shop_bill_id',
                'shop_room_id',
                'amount',
                'price',
                'price_child',
                'human_extra',
                'child_extra',
                'price_extra',
                'date_from',
                'date_to',
                'days',
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
            ->rule('shop_bill_id', 'max_length', array(':value', 11))
            ->rule('shop_room_id', 'max_length', array(':value', 11))
            ->rule('amount', 'max_length', array(':value', 12))
            ->rule('price', 'max_length', array(':value', 12))
            ->rule('price_child', 'max_length', array(':value', 12))
            ->rule('human_extra', 'max_length', array(':value', 11))
            ->rule('child_extra', 'max_length', array(':value', 11))
            ->rule('days', 'max_length', array(':value', 4))
            ->rule('price_extra', 'max_length', array(':value', 12));

        return $this->_validationFields($validation, $errorFields);
    }

    /**
     * Возвращаем cписок всех переменных
     */
    public function getValues($isGetElement = FALSE, $isParseArray = FALSE, $shopID = NULL)
    {
        $arr = parent::getValues($isGetElement, $isParseArray, $shopID);

        $arr['date_to'] = $this->getDateTo();

        return $arr;
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

    public function setShopRoomID($value){
        $this->setValueInt('shop_room_id', $value);
    }
    public function getShopRoomID(){
        return $this->getValueInt('shop_room_id');
    }

    public function setDateFrom($value){
        $this->setValueDate('date_from', $value);

        $this->setDays(Helpers_DateTime::diffDays($this->getDateTo(), $this->getDateFrom()));
    }
    public function getDateFrom(){
        return $this->getValueDateTime('date_from');
    }

    // сохраняем дату на 1 день меньше, при выводе увеличиваем дату на 1 день
    public function setDateTo($value){
        if ($value !== NULL) {
            $value = date('Y-m-d', strtotime($value) - 60 * 60 * 24);
        }
        $this->setValueDate('date_to', $value);

        $this->setDays(Helpers_DateTime::diffDays($this->getDateTo(), $this->getDateFrom()));
    }
    public function getDateTo(){
        $value = $this->getValueDateTime('date_to');
        if(!empty($value)){
            $value = date('Y-m-d', strtotime($value) + 60*60*24);
        }
        return $value;
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

    public function setDays($value){
        if ($value < 0){
            $value = 0;
        }
        $this->setValueInt('days', $value);
    }
    public function getDays(){
        return $this->getValueInt('days');
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
