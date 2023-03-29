<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ab1_Shop_Client_Contract_Contact extends Model_Shop_Table_Basic_Table{

    const TABLE_NAME = 'ab_shop_client_contract_contacts';
    const TABLE_ID = '';

    public function __construct(){
        parent::__construct(
            array(
			'format',
			'shop_client_contract_id',
			'client_contract_contact_type_id',
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
                    case 'shop_client_contract_id':
                        $this->_dbGetElement($this->getShopClientContractID(), 'shop_client_contract_id', new Model_Ab1_Shop_Client_Contract(), $shopID);
                        break;
                    case 'client_contract_contact_type_id':
                        $this->_dbGetElement($this->getClientContractContactTypeID(), 'client_contract_contact_type_id', new Model_Ab1_ClientContract_Contact_Type(), $shopID);
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

        $this->isValidationFieldStr('format', $validation);
        $this->isValidationFieldInt('shop_client_contract_id', $validation);
        $this->isValidationFieldInt('client_contract_contact_type_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setFormat($value){
        $this->setValue('format', $value);
    }
    public function getFormat(){
        return $this->getValue('format');
    }

    public function setShopClientContractID($value){
        $this->setValueInt('shop_client_contract_id', $value);
    }
    public function getShopClientContractID(){
        return $this->getValueInt('shop_client_contract_id');
    }

    public function setClientContractContactTypeID($value){
        $this->setValueInt('client_contract_contact_type_id', $value);
    }
    public function getClientContractContactTypeID(){
        return $this->getValueInt('client_contract_contact_type_id');
    }


}
