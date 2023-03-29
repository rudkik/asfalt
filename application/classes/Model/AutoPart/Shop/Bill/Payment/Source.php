<?php defined('SYSPATH') or die('No direct script access.');

class Model_AutoPart_Shop_Bill_Payment_Source extends Model_Shop_Table_Basic_Table{

    const TABLE_NAME = 'ap_shop_bill_payment_sources';
    const TABLE_ID = '';

    public function __construct(){
        parent::__construct(
            array(
			'is_check',
			'shop_source_id',
			'amount',
			'date',
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
                   case 'shop_source_id':
                            $this->_dbGetElement($this->getShopSourceID(), 'shop_source_id', new Model_AutoPart_Shop_Source(), $shopID);
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

        $this->isValidationFieldBool('is_check', $validation);
        $this->isValidationFieldInt('shop_source_id', $validation);
        $this->isValidationField('amount', $validation);
        $this->isValidationField('date', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setIsCheck($value){
        $this->setValueBool('is_check', $value);
    }
    public function getIsCheck(){
        return $this->getValueBool('is_check');
    }

    public function setShopSourceID($value){
        $this->setValueInt('shop_source_id', $value);
    }
    public function getShopSourceID(){
        return $this->getValueInt('shop_source_id');
    }

    public function setAmount($value){
        $this->setValueFloat('amount', $value);
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }

    public function setDate($value){
        $this->setValueDateTime('date', $value);
    }
    public function getDate(){
        return $this->getValueDateTime('date');
    }


}
