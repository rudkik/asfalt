<?php defined('SYSPATH') or die('No direct script access.');


class Model_Tax_Shop_Invoice extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'tax_shop_invoices';
	const TABLE_ID = 101;

	public function __construct(){
		parent::__construct(
			array(
                'number',
                'shop_contractor_id',
                'date',
                'amount',
                'shop_contract_id',
                'shop_attorney_id',
                'paid_type_id',
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
                        $this->_dbGetElement($this->getShopContractID(), 'shop_contract_id', new Model_Tax_Shop_Contract());
                        break;
                    case 'shop_contractor_id':
                        $this->_dbGetElement($this->getShopContractorID(), 'shop_contractor_id', new Model_Tax_Shop_Contractor());
                        break;
                    case 'shop_attorney_id':
                        $this->_dbGetElement($this->getShopAttorneyID(), 'shop_attorney_id', new Model_Tax_Shop_Attorney());
                        break;
                    case 'paid_type_id':
                        $this->_dbGetElement($this->getPaidTypeID(), 'paid_type_id', new Model_Tax_PaidType());
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
        $validation->rule('number', 'max_length', array(':value', 50))
            ->rule('shop_contractor_id', 'max_length', array(':value', 11))
            ->rule('amount', 'max_length', array(':value', 12))
            ->rule('shop_attorney_id', 'max_length', array(':value', 11))
			->rule('address_delivery', 'max_length', array(':value', 250))
			->rule('shop_contract_id', 'max_length', array(':value', 11))
            ->rule('paid_type_id', 'max_length', array(':value', 11));

        return $this->_validationFields($validation, $errorFields);
    }

    public function setPaidTypeID($value){
        $this->setValueInt('paid_type_id', $value);
    }
    public function getPaidTypeID(){
        return $this->getValueInt('paid_type_id');
    }

    public function setShopContractID($value){
        $this->setValueInt('shop_contract_id', $value);
    }
    public function getShopContractID(){
        return $this->getValueInt('shop_contract_id');
    }

    public function setShopAttorneyID($value){
        $this->setValueInt('shop_attorney_id', $value);
    }
    public function getShopAttorneyID(){
        return $this->getValueInt('shop_attorney_id');
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

    public function setAddressDelivery($value){
        $this->setValue('address_delivery', $value);
    }
    public function getAddressDelivery(){
        return $this->getValue('address_delivery');
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
