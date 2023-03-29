<?php defined('SYSPATH') or die('No direct script access.');

class Model_AutoPart_Shop_Bill_Buyer extends Model_Shop_Table_Basic_Table{

    const TABLE_NAME = 'ap_shop_bill_buyers';
    const TABLE_ID = '';

    public function __construct(){
        parent::__construct(
            array(
			'lastName',
			'firstName',
			'phone',
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

        $this->isValidationFieldStr('lastName', $validation);
        $this->isValidationFieldStr('firstName', $validation);
        $this->isValidationFieldInt('phone', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setValue($name, $value) {
        parent::setValue($name, $value);

        if ($name == 'lastName' || $name == 'firstName'){
            $this->setName(
                Func::str_concat(
                    '', [$this->getFirstName(), $this->getLastName()], '', ' '
                )
            );
        }
    }

    public function setLastName($value){
        $this->setValue('lastName', $value);
    }
    public function getLastName(){
        return $this->getValue('lastName');
    }

    public function setFirstName($value){
        $this->setValue('firstName', $value);
    }
    public function getFirstName(){
        return $this->getValue('firstName');
    }

    public function setPhone($value){
        $this->setValueInt('phone', $value);
    }
    public function getPhone(){
        return $this->getValueInt('phone');
    }

    public function setShopSourceID($value){
        $this->setValueInt('shop_source_id', $value);
    }
    public function getShopSourceID(){
        return $this->getValueInt('shop_source_id');
    }
}
