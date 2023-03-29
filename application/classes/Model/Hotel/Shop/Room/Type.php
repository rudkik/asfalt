<?php defined('SYSPATH') or die('No direct script access.');


class Model_Hotel_Shop_Room_Type extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'hc_shop_room_types';
	const TABLE_ID = 142;

	public function __construct(){
		parent::__construct(
			array(
                'shop_building_id',
                'shop_floor_id',
                'human',
                'human_extra',
                'price',
                'price_child',
                'human_extra',
                'shop_room_type_id',
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
                    case 'shop_building_id':
                        $this->_dbGetElement($this->getShopBuildingID(), 'shop_building_id', new Model_Hotel_Shop_Building());
                        break;
                    case 'shop_floor_id':
                        $this->_dbGetElement($this->getShopBuildingID(), 'shop_floor_id', new Model_Hotel_Shop_Floor());
                        break;
                    case 'shop_room_type_id':
                        $this->_dbGetElement($this->getShopBuildingID(), 'shop_room_type_id', new Model_Hotel_Shop_Room_Type());
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
        $validation->rule('shop_building_id', 'max_length', array(':value', 11))
            ->rule('shop_floor_id', 'max_length', array(':value', 11))
            ->rule('human', 'max_length', array(':value', 11))
            ->rule('human_extra', 'max_length', array(':value', 11))
            ->rule('price', 'max_length', array(':value', 12))
            ->rule('price_child', 'max_length', array(':value', 12))
            ->rule('price_extra', 'max_length', array(':value', 12))
            ->rule('shop_room_type_id', 'max_length', array(':value', 11));

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopBuildingID($value){
        $this->setValueInt('shop_building_id', $value);
    }
    public function getShopBuildingID(){
        return $this->getValueInt('shop_building_id');
    }

    public function setShopFloorID($value){
        $this->setValueInt('shop_floor_id', $value);
    }
    public function getShopFloorID(){
        return $this->getValueInt('shop_floor_id');
    }

    public function setShopRoomTypeID($value){
        $this->setValueInt('shop_room_type_id', $value);
    }
    public function getShopRoomTypeID(){
        return $this->getValueInt('shop_room_type_id');
    }

    public function setHuman($value){
        $this->setValueInt('human', $value);
    }
    public function getHuman(){
        return $this->getValueInt('human');
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

    public function setPriceChild($value){
        $this->setValueFloat('price_child', $value);
    }
    public function getPriceChild(){
        return $this->getValueFloat('price_child');
    }

    public function setPriceExtra($value){
        $this->setValueFloat('price_extra', $value);
    }
    public function getPriceExtra(){
        return $this->getValueFloat('price_extra');
    }
}
