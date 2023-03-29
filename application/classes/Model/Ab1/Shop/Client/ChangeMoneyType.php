<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ab1_Shop_Client_ChangeMoneyType extends Model_Shop_Table_Basic_Table{

    const TABLE_NAME = 'ab_shop_client_change_money_types';
    const TABLE_ID = '';

    public function __construct(){
        parent::__construct(
            array(
			'shop_client_id',
			'is_cash',
			'amount',
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
                   case 'shop_client_id':
                            $this->_dbGetElement($this->getShopClientID(), 'shop_client_id', new Model_Ab1_Shop_Client(), $shopID);
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

        $this->isValidationFieldInt('shop_client_id', $validation);
        $this->isValidationFieldBool('is_cash', $validation);
        $validation->rule('amount', 'max_length', array(':value',13));


        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopClientID($value){
        $this->setValueInt('shop_client_id', $value);
    }
    public function getShopClientID(){
        return $this->getValueInt('shop_client_id');
    }

    public function setIsCash($value){
        $this->setValueBool('is_cash', $value);
    }
    public function getIsCash(){
        return $this->getValueBool('is_cash');
    }

    public function setAmount($value){
        $this->setValueFloat('amount', $value);
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }


}
