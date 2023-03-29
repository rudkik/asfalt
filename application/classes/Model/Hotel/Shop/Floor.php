<?php defined('SYSPATH') or die('No direct script access.');


class Model_Hotel_Shop_Floor extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'hc_shop_floors';
	const TABLE_ID = 140;

	public function __construct(){
		parent::__construct(
			array(
                'shop_building_id'
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
        $validation->rule('shop_building_id', 'max_length', array(':value', 11));

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopBuildingID($value){
        $this->setValueInt('shop_building_id', $value);
    }
    public function getShopBuildingID(){
        return $this->getValueInt('shop_building_id');
    }
}
