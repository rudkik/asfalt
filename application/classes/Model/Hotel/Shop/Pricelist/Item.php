<?php defined('SYSPATH') or die('No direct script access.');


class Model_Hotel_Shop_Pricelist_Item extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'hc_shop_pricelist_items';
	const TABLE_ID = 144;

	public function __construct(){
		parent::__construct(
			array(
                'shop_pricelist_id',
                'shop_room_id',
                'price',
                'price_child',
                'price_feast',
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
                    case 'shop_pricelist_id':
                        $this->_dbGetElement($this->getShopPricelistID(), 'shop_pricelist_id', new Model_Hotel_Shop_Pricelist());
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
        $validation->rule('shop_pricelist_id', 'max_length', array(':value', 11))
            ->rule('shop_room_id', 'max_length', array(':value', 11))
            ->rule('price', 'max_length', array(':value', 12))
            ->rule('price_child', 'max_length', array(':value', 12))
            ->rule('price_extra', 'max_length', array(':value', 12));

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopPricelistID($value){
        $this->setValueInt('shop_pricelist_id', $value);
    }
    public function getShopPricelistID(){
        return $this->getValueInt('shop_pricelist_id');
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

    public function setPriceFeast($value){
        $this->setValueFloat('price_feast', $value);
    }
    public function getPriceFeast(){
        return $this->getValueFloat('price_feast');
    }
}
