<?php defined('SYSPATH') or die('No direct script access.');

class Model_AutoPart_Shop_Payment_Source extends Model_Shop_Table_Basic_Table{

    const TABLE_NAME = 'ap_shop_payment_sources';
    const TABLE_ID = '';

    public function __construct(){
        parent::__construct(
            array(
                'is_check',
                'date',
                'shop_source_id',
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
        $this->isValidationFieldFloat('amount', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setIsCheck($value){
        $this->setValueBool('is_check', $value);
    }
    public function getIsCheck(){
        return $this->getValueBool('is_check');
    }

    public function setIsLoadFile($value){
        $this->setValueBool('is_load_file', $value);
    }
    public function getIsLoadFile(){
        return $this->getValueBool('is_load_file');
    }

    public function setDate($value){
        $this->setValueDate('date', $value);
    }
    public function getDate(){
        return $this->getValueDate('date');
    }

    public function setShopSourceID($value){
        $this->setValueInt('shop_source_id', $value);
    }
    public function getShopSourceID(){
        return $this->getValueInt('shop_source_id');
    }

    public function setShopCompanyID($value){
        $this->setValueInt('shop_company_id', $value);
    }
    public function getShopCompanyID(){
        return $this->getValueInt('shop_company_id');
    }

    public function setAmount($value){
        $this->setValueFloat('amount', $value);
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }

    public function setAmountBillItems($value){
        $this->setValueFloat('amount_bill_items', $value);
    }
    public function getAmountBillItems(){
        return $this->getValueFloat('amount_bill_items');
    }

    public function setQuantityBillItems($value){
        $this->setValueFloat('quantity_bill_items', $value);
    }
    public function getQuantityBillItems(){
        return $this->getValueFloat('quantity_bill_items');
    }

    public function setNumber($value){
        $this->setValue('number', $value);
    }
    public function getNumber(){
        return $this->getValue('number');
    }

    public function setIIK($value){
        $this->setValue('iik', $value);
    }
    public function getIIK(){
        return $this->getValue('iik');
    }

    public function setKPN($value){
        $this->setValue('kpn', $value);
    }
    public function getKPN(){
        return $this->getValue('kpn');
    }

    public function setShopBankAccountID($value){
        $this->setValueInt('shop_bank_account_id', $value);
    }
    public function getShopBankAccountID(){
        return $this->getValueInt('shop_bank_account_id');
    }

    public function setCommissionSource($value){
        $this->setValueFloat('commission_source', $value);
    }
    public function getCommissionSource(){
        return $this->getValueFloat('commission_source');
    }
}
