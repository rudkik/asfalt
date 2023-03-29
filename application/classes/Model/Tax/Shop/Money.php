<?php defined('SYSPATH') or die('No direct script access.');


class Model_Tax_Shop_Money extends Model_Shop_Basic_Options{

	const TABLE_NAME = 'tax_shop_moneys';
	const TABLE_ID = 169;

	public function __construct(){
		parent::__construct(
			array(
                'amount',
                'shop_contract_id',
                'shop_contractor_id',
                'is_cash',
                'is_coming',
                'date',
                'number',
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
                    case 'shop_contract_id':
                        $this->_dbGetElement($this->getBalnceTypeID(), 'money_type_id', new Model_Tax_MoneyType());
                        break;
                    case 'shop_contractor_id':
                        $this->_dbGetElement($this->getShopContractorID(), 'shop_contractor_id', new Model_Tax_Shop_Contractor());
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
        $validation->rule('amount', 'max_length', array(':value', 12))
            ->rule('number', 'max_length', array(':value', 12))
            ->rule('shop_contract_id', 'max_length', array(':value', 11))
            ->rule('shop_contractor_id', 'max_length', array(':value', 11))
            ->rule('is_cash', 'max_length', array(':value', 1))
            ->rule('is_coming', 'max_length', array(':value', 1));

        return $this->_validationFields($validation, $errorFields);
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
        return $this->getValueFloat('date');
    }

    public function setAmount($value){
        $this->setValueDate('amount', $value);
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }

    public function setShopContractID($value){
        $this->setValueInt('shop_contract_id', $value);
    }
    public function getShopContractID(){
        return $this->getValueInt('shop_contract_id');
    }

    public function setShopContractorID($value){
        $this->setValueInt('shop_contractor_id', $value);
    }
    public function getShopContractorID(){
        return $this->getValueInt('shop_contractor_id');
    }

    public function setIsCash($value){
        $this->setValueBool('is_cash', $value);
    }
    public function getIsCash(){
        return $this->getValueBool('is_cash');
    }

    public function getIsComing(){
        return $this->getValueBool('is_coming');
    }
    public function setIsComing($value){
        $this->setValueBool('is_coming', $value);
    }
}
