<?php defined('SYSPATH') or die('No direct script access.');


class Model_AutoPart_Shop_Operation extends Model_Shop_Operation
{
    public function __construct(){
        parent::__construct(
            array(
                'shop_position_id',
                'shop_courier_id',
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
                    case 'shop_position_id':
                        $this->_dbGetElement($this->getShopPositionID(), 'shop_position_id', new Model_AutoPart_Shop_Position(), $shopID);
                        break;
                    case 'shop_courier_id':
                        $this->_dbGetElement($this->getShopCourierID(), 'shop_courier_id', new Model_AutoPart_Shop_Courier(), $shopID);
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

        if ($this->id < 1) {
            $validation->rule('password', 'not_empty');
            $validation->rule('email', 'not_empty');
        }

        $validation->rule('name', 'max_length', array(':value', 250))
            ->rule('user_id', 'max_length', array(':value', 11))
            ->rule('is_admin', 'max_length', array(':value', 1))
            ->rule('email', 'max_length', array(':value', 150))
            ->rule('password', 'max_length', array(':value', 150))
            ->rule('access', 'max_length', array(':value', 650000))
            ->rule('password', 'not_null')
            ->rule('email', 'not_null')
            ->rule('user_hash', 'max_length', array(':value', 32));

        if ($this->isFindFieldAndIsEdit('user_id')) {
            $validation->rule('user_id', 'digit');
        }

        if ($this->isFindFieldAndIsEdit('is_admin')) {
            $validation->rule('is_admin', 'digit');
        }

        $this->isValidationFieldInt('shop_position_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopPositionID($value){
        $this->setValueInt('shop_position_id', $value);
    }
    public function getShopPositionID(){
        return $this->getValueInt('shop_position_id');
    }

    public function setShopCourierID($value){
        $this->setValueInt('shop_courier_id', $value);
    }
    public function getShopCourierID(){
        return $this->getValueInt('shop_courier_id');
    }
}
