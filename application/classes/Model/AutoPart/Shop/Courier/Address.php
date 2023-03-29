<?php defined('SYSPATH') or die('No direct script access.');

class Model_AutoPart_Shop_Courier_Address extends Model_Shop_Table_Basic_Table{

    const TABLE_NAME = 'ap_shop_courier_addresses';
    const TABLE_ID = '';

    public function __construct(){
        parent::__construct(
            array(
			'street',
			'house',
			'apartment',
			'city_name',
			'city_id',
			'latitude',
			'longitude',
			'shop_courier_id',
            ),
            self::TABLE_NAME,
            self::TABLE_ID
        );

        $this->isAddCreated = TRUE;
    }

    /**
     * Получение данных для вспомогательных элементов из базы данных
     * и добавление его в массив
     * @param int $shopID
     * @param null | array $elements
     * @return bool
     */
    public function dbGetElements($shopID = 0, $elements = NULL){
        if(($elements !== NULL) && (is_array($elements))){
            foreach($elements as $element){
                switch($element){
                   case 'city_id':
                            $this->_dbGetElement($this->getCityID(), 'city_id', new Model_City(), $shopID);
                            break;
                   case 'shop_courier_id':
                            $this->_dbGetElement($this->getShopCourierID(), 'shop_courier_id', new Model_AutoPart_Shop_Courier(), $shopID);
                            break;
                 }
            }
        }

        return parent::dbGetElements($shopID, $elements);
    }

    /**
     * Проверяем поля на ошибки
     * @param array $errorFields - массив ошибок
     * @return boolean
     */
    public function validationFields(array &$errorFields)
    {
        $validation = new Validation($this->getValues());

        $this->isValidationFieldStr('street', $validation);
        $this->isValidationFieldStr('house', $validation);
        $this->isValidationFieldStr('apartment', $validation);
        $this->isValidationFieldStr('city_name', $validation);
        $this->isValidationFieldInt('city_id', $validation);
        $validation->rule('latitude', 'max_length', array(':value',13));

        $validation->rule('longitude', 'max_length', array(':value',13));

        $this->isValidationFieldInt('shop_courier_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setValue($name, $value) {
        parent::setValue($name, $value);

        if ($name == 'street' || $name == 'house' || $name == 'apartment' || $name == 'city_name'){
            $this->setName(
                Func::str_concat(
                    '', [$this->getCityName(), $this->getStreet(), $this->getHouse(), $this->getApartment()], '', ', '
                )
            );
        }
    }

    public function setStreet($value){
        $this->setValue('street', $value);
    }
    public function getStreet(){
        return $this->getValue('street');
    }

    public function setHouse($value){
        $this->setValue('house', $value);
    }
    public function getHouse(){
        return $this->getValue('house');
    }

    public function setApartment($value){
        $this->setValue('apartment', $value);
    }
    public function getApartment(){
        return $this->getValue('apartment');
    }

    public function setCityName($value){
        $this->setValue('city_name', $value);
    }
    public function getCityName(){
        return $this->getValue('city_name');
    }

    public function setCityID($value){
        $this->setValueInt('city_id', $value);
    }
    public function getCityID(){
        return $this->getValueInt('city_id');
    }

    public function setLatitude($value){
        $this->setValueFloat('latitude', $value);
    }
    public function getLatitude(){
        return $this->getValueFloat('latitude');
    }

    public function setLongitude($value){
        $this->setValueFloat('longitude', $value);
    }
    public function getLongitude(){
        return $this->getValueFloat('longitude');
    }

    public function setShopCourierID($value){
        $this->setValueInt('shop_courier_id', $value);
    }
    public function getShopCourierID(){
        return $this->getValueInt('shop_courier_id');
    }


}
