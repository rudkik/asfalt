<?php defined('SYSPATH') or die('No direct script access.');


class Model_Tax_Shop_Invoice_Proforma extends Model_Shop_Basic_Options{

	const TABLE_NAME = 'tax_shop_invoice_proformas';
	const TABLE_ID = 166;

	public function __construct(){
		parent::__construct(
			array(
                'number',
                'shop_contractor_id',
                'date',
                'amount',
                'shop_contract_id',
                'knp_id',
                'is_nds',
                'nds',
                'shop_bank_account_id',
                'shop_invoice_commercial_ids',
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
                    case 'shop_contract_id':
                        $this->_dbGetElement($this->getShopContractID(), 'shop_contract_id', new Model_Tax_Shop_Contract());
                        break;
                    case 'shop_contractor_id':
                        $this->_dbGetElement($this->getShopContractorID(), 'shop_contractor_id', new Model_Tax_Shop_Contractor());
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
            ->rule('knp_id', 'max_length', array(':value', 11))
            ->rule('amount', 'max_length', array(':value', 12))
            ->rule('nds', 'max_length', array(':value', 5))
            ->rule('is_nds', 'max_length', array(':value', 1))
			->rule('shop_contract_id', 'max_length', array(':value', 11));

        return $this->_validationFields($validation, $errorFields);
    }

    /**
     * Возвращаем список всех переменных
     * @param bool $isGetElement
     * @param bool $isParseArray
     * @param null $shopID
     * @return array
     */
    public function getValues($isGetElement = FALSE, $isParseArray = FALSE, $shopID = NULL)
    {
        $arr = parent::getValues($isGetElement, $isParseArray, $shopID);

        if($isParseArray === TRUE) {
            $arr['shop_invoice_commercial_ids'] = $this->getShopInvoiceCommercialIDs();
        }

        return $arr;
    }

    /**
     * @param int|array $value
     */
    public function setShopInvoiceCommercialIDs($value){
        if (is_array($value)){
            $value = Helpers_Array::getUniqueNumbers($value);
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
    public function addShopInvoiceCommercialIDs($value){
        $arr = $this->getShopInvoiceCommercialIDsArray();
        if (is_array($value)){
            $arr = array_merge($arr, $value);
        }else{
            $arr[] = $value;
        }

        $this->setShopInvoiceCommercialIDs($arr);
    }

    public function setShopBankAccountID($value){
        $this->setValueInt('shop_bank_account_id', $value);
    }
    public function getShopBankAccountID(){
        return $this->getValueInt('shop_bank_account_id');
    }

    public function setKNPID($value){
        $this->setValueInt('knp_id', $value);
    }
    public function getKNPID(){
        return $this->getValueInt('knp_id');
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
}
