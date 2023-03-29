<?php defined('SYSPATH') or die('No direct script access.');


class Model_Tax_Shop_Balance extends Model_Shop_Basic_Options{

	const TABLE_NAME = 'tax_shop_balances';
	const TABLE_ID = 167;

	public function __construct(){
		parent::__construct(
			array(
                'amount',
                'balance_type_id',
                'shop_contractor_id',
                'shop_my_invoice_id',
                'shop_my_invoice_id',
                'date',
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
                    case 'balance_type_id':
                        $this->_dbGetElement($this->getBalnceTypeID(), 'balance_type_id', new Model_Tax_BalanceType());
                        break;
                    case 'shop_contractor_id':
                        $this->_dbGetElement($this->getShopContractorID(), 'shop_contractor_id', new Model_Tax_Shop_Contractor());
                        break;
                    case 'shop_invoice_commercial_id':
                        $this->_dbGetElement($this->getShopInvoiceCommercialID(), 'shop_invoice_commercial_id', new Model_Tax_Shop_Invoice_Commercial());
                        break;
                    case 'shop_my_invoice_id':
                        $this->_dbGetElement($this->getShopMyInvoiceID(), 'shop_my_invoice_id', new Model_Tax_Shop_My_Invoice());
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
            ->rule('balance_type_id', 'max_length', array(':value', 11))
            ->rule('shop_contractor_id', 'max_length', array(':value', 11))
            ->rule('shop_invoice_commercial_id', 'max_length', array(':value', 11))
            ->rule('shop_my_invoice_id', 'max_length', array(':value', 11));

        return $this->_validationFields($validation, $errorFields);
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

    public function setBalanceTypeID($value){
        $this->setValueInt('balance_type_id', $value);
    }
    public function getBalanceTypeID(){
        return $this->getValueInt('balance_type_id');
    }

    public function setShopContractorID($value){
        $this->setValueInt('shop_contractor_id', $value);
    }
    public function getShopContractorID(){
        return $this->getValueInt('shop_contractor_id');
    }

    public function setShopInvoiceCommercialID($value){
        $this->setValueInt('shop_invoice_commercial_id', $value);
    }
    public function getShopInvoiceCommercialID(){
        return $this->getValueInt('shop_invoice_commercial_id');
    }

    public function getShopMyInvoiceID($value){
        $this->setValueInt('shop_my_invoice_id', $value);
    }
    public function setShopMyInvoiceID(){
        return $this->getValueInt('shop_my_invoice_id');
    }
}
