<?php defined('SYSPATH') or die('No direct script access.');

class Model_AutoPart_Shop_Bank_Account extends Model_Shop_Table_Basic_Table{

    const TABLE_NAME = 'ap_shop_bank_accounts';
    const TABLE_ID = '';

    public function __construct(){
        parent::__construct(
            array(
			'bank_id',
			'shop_company_id',
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
                   case 'bank_id':
                            $this->_dbGetElement($this->getBankID(), 'bank_id', new Model_Bank(), $shopID);
                            break;
                   case 'shop_company_id':
                            $this->_dbGetElement($this->getShopCompanyID(), 'shop_company_id', new Model_AutoPart_Shop_Company(), $shopID);
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

        $this->isValidationFieldInt('bank_id', $validation);
        $this->isValidationFieldInt('shop_company_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setBankID($value){
        $this->setValueInt('bank_id', $value);
    }
    public function getBankID(){
        return $this->getValueInt('bank_id');
    }

    public function setShopCompanyID($value){
        $this->setValueInt('shop_company_id', $value);
    }
    public function getShopCompanyID(){
        return $this->getValueInt('shop_company_id');
    }


}
