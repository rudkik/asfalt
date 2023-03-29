<?php defined('SYSPATH') or die('No direct script access.');

class Model_AutoPart_Shop_Bank_Account_Balance extends Model_Shop_Table_Basic_Table{

    const TABLE_NAME = 'ap_shop_bank_account_balances';
    const TABLE_ID = '';

    public function __construct(){
        parent::__construct(
            array(
			'shop_company_id',
			'shop_bank_account_id',
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
                   case 'shop_company_id':
                            $this->_dbGetElement($this->getShopCompanyID(), 'shop_company_id', new Model_AutoPart_Shop_Company(), $shopID);
                            break;
                   case 'shop_bank_account_id':
                            $this->_dbGetElement($this->getShopAccountID(), 'shop_bank_account_id', new Model_AutoPart_Shop_Bank_Account(), $shopID);
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

        $this->isValidationFieldInt('shop_company_id', $validation);
        $this->isValidationFieldInt('shop_bank_account_id', $validation);
        $validation->rule('amount', 'max_length', array(':value',13));


        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopCompanyID($value){
        $this->setValueInt('shop_company_id', $value);
    }
    public function getShopCompanyID(){
        return $this->getValueInt('shop_company_id');
    }

    public function setShopBankAccountID($value){
        $this->setValueInt('shop_bank_account_id', $value);
    }
    public function getShopBankAccountID(){
        return $this->getValueInt('shop_bank_account_id');
    }

    public function setAmount($value){
        $this->setValueFloat('amount', $value);
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }

    public function setDate($value){
        $this->setValueDate('date', $value);
    }
    public function getDate(){
        return $this->getValueDate('date');
    }


}
