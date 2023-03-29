<?php defined('SYSPATH') or die('No direct script access.');

class Model_AutoPart_Shop_Bill_Call extends Model_Shop_Table_Basic_Table{

    const TABLE_NAME = 'ap_shop_bill_calls';
    const TABLE_ID = '';

    public function __construct(){
        parent::__construct(
            array(
			'shop_operation_id',
			'shop_bill_call_status_id',
			'shop_bill_id',
			'call_at',
			'plan_call_at',
			'is_call',
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
                   case 'shop_operation_id':
                            $this->_dbGetElement($this->getShopOperationID(), 'shop_operation_id', new Model_AutoPart_Shop_Operation(), $shopID);
                            break;
                   case 'shop_bill_call_status_id':
                            $this->_dbGetElement($this->getShopBillCallStatusID(), 'shop_bill_call_status_id', new Model_AutoPart_Shop_Bill_Call_Status(), $shopID);
                            break;
                   case 'shop_bill_id':
                            $this->_dbGetElement($this->getShopBillID(), 'shop_bill_id', new Model_AutoPart_Shop_Bill(), $shopID);
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

        $this->isValidationFieldInt('shop_operation_id', $validation);
        $this->isValidationFieldInt('shop_bill_call_status_id', $validation);
        $this->isValidationFieldInt('shop_bill_id', $validation);
        $this->isValidationFieldBool('is_call', $validation);
        $this->isValidationFieldStr('phone', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopOperationID($value){
        $this->setValueInt('shop_operation_id', $value);
    }
    public function getShopOperationID(){
        return $this->getValueInt('shop_operation_id');
    }

    public function setShopBillCallStatusID($value){
        $this->setValueInt('shop_bill_call_status_id', $value);
    }
    public function getShopBillCallStatusID(){
        return $this->getValueInt('shop_bill_call_status_id');
    }

    public function setShopBillID($value){
        $this->setValueInt('shop_bill_id', $value);
    }
    public function getShopBillID(){
        return $this->getValueInt('shop_bill_id');
    }

    public function setCallAt($value){
        $this->setValueDateTime('call_at', $value);
    }
    public function getCallAt(){
        return $this->getValueDateTime('call_at');
    }

    public function setPlanCallAt($value){
        $this->setValueDateTime('plan_call_at', $value);
    }
    public function getPlanCallAt(){
        return $this->getValueDateTime('plan_call_at');
    }

    public function setIsCall($value){
        $this->setValueBool('is_call', $value);
    }
    public function getIsCall(){
        return $this->getValueBool('is_call');
    }

    public function setPhone($value){
        $this->setValue('phone', $value);
    }
    public function getPhone(){
        return $this->getValue('phone');
    }


}
