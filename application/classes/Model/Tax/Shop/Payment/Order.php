<?php defined('SYSPATH') or die('No direct script access.');


class Model_Tax_Shop_Payment_Order extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'tax_shop_payment_orders';
	const TABLE_ID = 133;

	public function __construct(){
		parent::__construct(
			array(
                'number',
                'shop_contractor_id',
                'date',
                'amount',
                'kbe_id',
                'knp_id',
                'kbk_id',
                'authority_id',
                'gov_contractor_id',
                'shop_bank_account_id',
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
                    case 'knp_id':
                        $this->_dbGetElement($this->getKNPID(), 'knp_id', new Model_Tax_KNP());
                        break;
                    case 'shop_contractor_id':
                        $this->_dbGetElement($this->getShopContractorID(), 'shop_contractor_id', new Model_Tax_Shop_Contractor());
                        break;
                    case 'kbk_id':
                        $this->_dbGetElement($this->getKBKID(), 'kbk_id', new Model_Tax_KBK());
                        break;
                    case 'kbe_id':
                        $this->_dbGetElement($this->getKBeID(), 'kbe_id', new Model_Tax_KBe());
                        break;
                    case 'authority_id':
                        $this->_dbGetElement($this->getAuthorityID(), 'authority_id', new Model_Tax_Authority());
                        break;
                    case 'gov_contractor_id':
                        $this->_dbGetElement($this->getGovContractorID(), 'gov_contractor_id', new Model_Tax_GovContractor());
                        break;
                    case 'shop_bank_account_id':
                        $this->_dbGetElement($this->getShopBankAccountID(), 'shop_bank_account_id', new Model_Tax_Shop_Bank_Account());
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
        $this->isValidationFieldInt('shop_bank_account_id', $validation);

        $validation->rule('number', 'max_length', array(':value', 50))
            ->rule('shop_contractor_id', 'max_length', array(':value', 11))
            ->rule('amount', 'max_length', array(':value', 12))
            ->rule('kbe_id', 'max_length', array(':value', 11))
            ->rule('knp_id', 'max_length', array(':value', 11))
            ->rule('authority_id', 'max_length', array(':value', 11))
            ->rule('gov_contractor_id', 'max_length', array(':value', 11))
            ->rule('kbk_id', 'max_length', array(':value', 11));

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopBankAccountID($value){
        $this->setValueInt('shop_bank_account_id', $value);
    }
    public function getShopBankAccountID(){
        return $this->getValueInt('shop_bank_account_id');
    }


    public function setIsItems($value){
        $this->setValueBool('is_items', $value);
    }
    public function getIsItems(){
        return $this->getValueBool('is_items');
    }

    public function setAuthorityID($value){
        $this->setValueInt('authority_id', $value);
    }
    public function getAuthorityID(){
        return $this->getValueInt('authority_id');
    }

    public function setGovContractorID($value){
        $this->setValueInt('gov_contractor_id', $value);
    }
    public function getGovContractorID(){
        return $this->getValueInt('gov_contractor_id');
    }

    public function setKNPID($value){
        $this->setValueInt('knp_id', $value);
    }
    public function getKNPID(){
        return $this->getValueInt('knp_id');
    }

    public function setKBKID($value){
        $this->setValueInt('kbk_id', $value);
    }
    public function getKBKID(){
        return $this->getValueInt('kbk_id');
    }

    public function setKBeID($value){
        $this->setValueInt('kbe_id', $value);
    }
    public function getKBeID(){
        return $this->getValueInt('kbe_id');
    }

    public function setShopContractorID($value){
        $this->setValueInt('shop_contractor_id', $value);
    }
    public function getShopContractorID(){
        return $this->getValueInt('shop_contractor_id');
    }

    public function setNumber($value){
        $this->setValue('number', $value);
    }
    public function getNumber(){
        return $this->getValue('number');
    }

    public function setDate($value){
        $this->setValueDate('date', $value);
    }
    public function getDate(){
        return $this->getValueDateTime('date');
    }

    public function setAmount($value){
        $this->setValueFloat('amount', $value);
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }
}
