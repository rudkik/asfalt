<?php defined('SYSPATH') or die('No direct script access.');


class Model_Hotel_Shop_Holiday_Day extends Model_Shop_Basic_Options{

	const TABLE_NAME = 'hc_shop_holiday_days';
	const TABLE_ID = 177;

	public function __construct(){
		parent::__construct(
			array(
                'shop_holiday_id',
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
                    case 'shop_holiday_id':
                        $this->_dbGetElement($this->getShopHolidayID(), 'shop_holiday_id', new Model_Hotel_Shop_Holiday());
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
        $validation->rule('shop_holiday_id', 'max_length', array(':value', 11));

        return $this->_validationFields($validation, $errorFields);
    }
    public function setShopHolidayID($value){
        $this->setValueInt('shop_holiday_id', $value);
    }
    public function getShopHolidayID(){
        return $this->getValueInt('shop_holiday_id');
    }

    public function setDate($value){
        $this->setValueDate('date', $value);
    }
    public function getDate(){
        return $this->getValueDateTime('date');
    }
}
