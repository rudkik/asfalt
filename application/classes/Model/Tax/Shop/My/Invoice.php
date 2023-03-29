<?php defined('SYSPATH') or die('No direct script access.');


class Model_Tax_Shop_My_Invoice extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'tax_shop_my_invoices';
	const TABLE_ID = 162;

	public function __construct(){
		parent::__construct(
			array(
                'number',
                'shop_contractor_id',
                'date',
                'amount',
                'shop_contract_id',
                'is_nds',
                'nds',
                'is_act_service',
                'act_service_number',
                'act_service_date',
                'is_act_product',
                'act_product_number',
                'act_product_date',
                'is_invoice_commercial',
                'invoice_commercial_number',
                'invoice_commercial_date',
                'is_cash_memo',
                'cash_memo_number',
                'cash_memo_date',
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
            ->rule('nds', 'max_length', array(':value', 5))
            ->rule('is_nds', 'max_length', array(':value', 1))
			->rule('shop_contract_id', 'max_length', array(':value', 11))
            ->rule('is_act_service', 'max_length', array(':value', 1))
            ->rule('act_service_number', 'max_length', array(':value', 50))
            ->rule('is_act_product', 'max_length', array(':value', 1))
            ->rule('act_product_number', 'max_length', array(':value', 50))
            ->rule('is_invoice_commercial', 'max_length', array(':value', 1))
            ->rule('invoice_commercial_number', 'max_length', array(':value', 50))
            ->rule('is_cash_memo', 'max_length', array(':value', 1))
            ->rule('cash_memo_number', 'max_length', array(':value', 50));


        return $this->_validationFields($validation, $errorFields);
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

    public function setIsNDS($value){
        $this->setValueBool('is_nds', $value);

        if (!$this->getIsNDS()){
            $this->setNDS(0);
        }
    }
    public function getIsNDS(){
        return $this->getValueBool('is_nds');
    }

    public function setNDS($value){
        $this->setValueFloat('nds', $value);
    }
    public function getNDS(){
        return $this->getValueFloat('nds');
    }

    public function setIsActService($value){
        $this->setValueBool('is_act_service', $value);
    }
    public function getIsActService(){
        return $this->getValueBool('is_act_service');
    }

    public function setActServiceNumber($value){
        $this->setValue('act_service_number', $value);
    }
    public function getActServiceNumber(){
        return $this->getValue('act_service_number');
    }

    public function setActServiceDate($value){
        $this->setValueDate('act_service_date', $value);
    }
    public function getActServiceDate(){
        return $this->getValueDateTime('act_service_date');
    }

    public function setIsActProduct($value){
        $this->setValueBool('is_act_product', $value);
    }
    public function getIsActProduct(){
        return $this->getValueBool('is_act_product');
    }

    public function setActProductNumber($value){
        $this->setValue('act_product_number', $value);
    }
    public function getActProductNumber(){
        return $this->getValue('act_product_number');
    }

    public function setActProductDate($value){
        $this->setValueDate('act_product_date', $value);
    }
    public function getActProductDate(){
        return $this->getValueDateTime('act_product_date');
    }

    public function setIsInvoiceCommercial($value){
        $this->setValueBool('is_invoice_commercial', $value);
    }
    public function getIsInvoiceCommercial(){
        return $this->getValueBool('is_invoice_commercial');
    }

    public function setInvoiceCommercialNumber($value){
        $this->setValue('invoice_commercial_number', $value);
    }
    public function getInvoiceCommercialNumber(){
        return $this->getValue('invoice_commercial_number');
    }

    public function setInvoiceCommercialDate($value){
        $this->setValueDate('invoice_commercial_date', $value);
    }
    public function getInvoiceCommercialDate(){
        return $this->getValueDateTime('invoice_commercial_date');
    }

    public function setIsCashMemo($value){
        $this->setValueBool('is_cash_memo', $value);
    }
    public function getIsCashMemo(){
        return $this->getValueBool('is_cash_memo');
    }

    public function setCashMemoNumber($value){
        $this->setValue('cash_memo_number', $value);
    }
    public function getCashMemoNumber(){
        return $this->getValue('cash_memo_number');
    }

    public function setCashMemoDate($value){
        $this->setValueDate('cash_memo_date', $value);
    }
    public function getCashMemoDate(){
        return $this->getValueDateTime('cash_memo_date');
    }

}
