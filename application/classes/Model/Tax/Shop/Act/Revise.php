<?php defined('SYSPATH') or die('No direct script access.');


class Model_Tax_Shop_Act_Revise extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'tax_shop_act_revises';
	const TABLE_ID = 175;

	public function __construct(){
		parent::__construct(
			array(
                'number',
                'shop_contractor_id',
                'date',
                'date_from',
                'date_to',
                'shop_contract_id',
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
			->rule('shop_contract_id', 'max_length', array(':value', 11));

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopInvoiceCommercialIDs($value){
        if (is_array($value)){
            $value = implode(', ', $value);
        }

        $this->setValue('shop_invoice_commercial_ids', $value);
    }
    public function getShopInvoiceCommercialIDs(){
        return $this->getValue('shop_invoice_commercial_ids');
    }
    public function getShopInvoiceCommercialIDsArray(){
        $value = $this->getShopInvoiceCommercialIDs();
        if (!empty($value)) {
            return explode(',', $value);
        }else{
            return array();
        }
    }

    public function setShopMyInvoiceIDs($value){
        if (is_array($value)){
            $value = implode(', ', $value);
        }

        $this->setValue('shop_my_invoice_ids', $value);
    }
    public function getShopMyInvoiceIDs(){
        return $this->getValue('shop_my_invoice_ids');
    }
    public function getShopMyInvoiceIDsArray(){
        $value = $this->getShopMyInvoiceIDs();
        if (!empty($value)) {
            return explode(',', $value);
        }else{
            return array();
        }
    }

    public function setShopPaymentOrderIDs($value){
        if (is_array($value)){
            $value = implode(', ', $value);
        }

        $this->setValue('shop_payment_order_ids', $value);
    }
    public function getShopPaymentOrderIDs(){
        return $this->getValue('shop_payment_order_ids');
    }
    public function getShopPaymentOrderIDsArray(){
        $value = $this->getShopPaymentOrderIDs();
        if (!empty($value)) {
            return explode(',', $value);
        }else{
            return array();
        }
    }

    public function setShopMoneyIDs($value){
        if (is_array($value)){
            $value = implode(', ', $value);
        }

        $this->setValue('shop_money_ids', $value);
    }
    public function getShopMoneyIDs(){
        return $this->getValue('shop_money_ids');
    }
    public function getShopMoneyIDsArray(){
        $value = $this->getShopMoneyIDs();
        if (!empty($value)) {
            return explode(',', $value);
        }else{
            return array();
        }
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
        return $this->getValue('date');
    }

    public function setDateFrom($value){
        $this->setValueDate('date_from', $value);
        $this->setDate($value);
    }
    public function getDateFrom(){
        return $this->getValueDateTime('date_from');
    }

    public function setDateTo($value){
        $this->setValueDate('date_to', $value);
    }
    public function getDateTo(){
        return $this->getValueDateTime('date_to');
    }
}
