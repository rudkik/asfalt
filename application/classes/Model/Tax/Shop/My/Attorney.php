<?php defined('SYSPATH') or die('No direct script access.');


class Model_Tax_Shop_My_Attorney extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'tax_shop_my_attorneys';
	const TABLE_ID = 123;

	public function __construct(){
		parent::__construct(
			array(
                'shop_contractor_id',
                'date',
                'date_from',
                'date_to',
                'number',
                'amount',
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
                    case 'shop_contractor_id':
                        $this->_dbGetElement($this->getShopContractorID(), 'shop_contractor_id', new Model_Tax_Shop_Contractor());
                        break;
                    case 'shop_worker_id':
                        $this->_dbGetElement($this->getShopWorkerID(), 'shop_worker_id', new Model_Tax_Shop_Worker());
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
        $validation->rule('shop_contractor_id', 'max_length', array(':value', 11))
            ->rule('shop_worker_id', 'max_length', array(':value', 11))
            ->rule('amount', 'max_length', array(':value', 12));

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopBankAccountID($value){
        $this->setValueInt('shop_bank_account_id', $value);
    }
    public function getShopBankAccountID(){
        return $this->getValueInt('shop_bank_account_id');
    }

    public function setShopContractorID($value){
        $this->setValueInt('shop_contractor_id', $value);
    }
    public function getShopContractorID(){
        return $this->getValueInt('shop_contractor_id');
    }

    public function setShopWorkerID($value){
        $this->setValueInt('shop_worker_id', $value);
    }
    public function getShopWorkerID(){
        return $this->getValueInt('shop_worker_id');
    }

    public function setDate($value){
        $this->setValueDate('date', $value);
    }
    public function getDate(){
        return $this->getValue('date');
    }

    public function setDateFrom($value){
        $this->setValueDate('date_from', $value);
        $this->setDate($value);
    }
    public function getDateFrom(){
        return $this->getValue('date_from');
    }

    public function setDateTo($value){
        $this->setValueDate('date_to', $value);
    }
    public function getDateTo(){
        return $this->getValue('date_to');
    }

    public function setNumber($value){
        $this->setValue('number', $value);
    }
    public function getNumber(){
        return $this->getValue('number');
    }

    public function setAmount($value){
        $this->setValueFloat('amount', $value);
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }
}
