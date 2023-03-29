<?php defined('SYSPATH') or die('No direct script access.');

class Model_AutoPart_Shop_Bill_Return extends Model_Shop_Table_Basic_Table{

    const TABLE_NAME = 'ap_shop_bill_returns';
    const TABLE_ID = '';

    public function __construct(){
        parent::__construct(
            array(
			'return_at',
			'plan_return_at',
			'shop_bill_id',
			'shop_bill_return_status_id',
			'is_return ',
			'is_refusal',
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
                   case 'shop_bill_id':
                            $this->_dbGetElement($this->getShopBillID(), 'shop_bill_id', new Model_AutoPart_Shop_Bill(), $shopID);
                            break;
                   case 'shop_bill_return_status_id':
                            $this->_dbGetElement($this->getShopBillReturnStatusID(), 'shop_bill_return_status_id', new Model_AutoPart_Shop_Bill_Return_Status(), $shopID);
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

        $this->isValidationFieldInt('shop_bill_id', $validation);
        $this->isValidationFieldInt('shop_bill_return_status_id', $validation);
        $this->isValidationFieldBool('is_return ', $validation);
        $this->isValidationFieldBool('is_refusal', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setReturnAt($value){
        $this->setValueDateTime('return_at', $value);
    }
    public function getReturnAt(){
        return $this->getValueDateTime('return_at');
    }

    public function setPlanReturnAt($value){
        $this->setValueDateTime('plan_return_at', $value);
    }
    public function getPlanReturnAt(){
        return $this->getValueDateTime('plan_return_at');
    }

    public function setShopBillID($value){
        $this->setValueInt('shop_bill_id', $value);
    }
    public function getShopBillID(){
        return $this->getValueInt('shop_bill_id');
    }

    public function setShopBillReturnStatusID($value){
        $this->setValueInt('shop_bill_return_status_id', $value);
    }
    public function getShopBillReturnStatusID(){
        return $this->getValueInt('shop_bill_return_status_id');
    }

    public function setIsReturn ($value){
        $this->setValueBool('is_return ', $value);
    }
    public function getIsReturn (){
        return $this->getValueBool('is_return ');
    }

    public function setIsRefusal($value){
        $this->setValueBool('is_refusal', $value);
    }
    public function getIsRefusal(){
        return $this->getValueBool('is_refusal');
    }


}
