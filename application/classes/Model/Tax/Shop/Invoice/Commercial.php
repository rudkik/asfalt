<?php defined('SYSPATH') or die('No direct script access.');


class Model_Tax_Shop_Invoice_Commercial extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'tax_shop_invoice_commercials';
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
                'is_nds',
                'nds',
                'shop_bank_account_id',
                'shop_invoice_proforma_ids',
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
            ->rule('shop_attorney_id', 'max_length', array(':value', 11))
			->rule('address_delivery', 'max_length', array(':value', 250))
			->rule('shop_contract_id', 'max_length', array(':value', 11))
            ->rule('nds', 'max_length', array(':value', 5))
            ->rule('is_nds', 'max_length', array(':value', 1))
            ->rule('paid_type_id', 'max_length', array(':value', 11));

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
            $arr['shop_invoice_proforma_ids'] = $this->findAll();
        }

        return $arr;
    }

    /**
     * @param int|array $value
     */
    public function setShopInvoiceProformaIDs($value){
        if (is_array($value)){
            $value = Helpers_Array::getUniqueNumbers($value);
            $value = implode(', ', $value);
        }

        $this->setValue('shop_invoice_proforma_ids', $value);
    }
    public function findAll(){
        return $this->getValue('shop_invoice_proforma_ids');
    }
    public function findAllArray(){
        $value = $this->findAll();
        if (!empty($value)) {
            return explode(',', $value);
        }else{
            return array();
        }
    }
    public function addShopInvoiceProformaIDs($value){
        $arr = $this->findAllArray();
        if (is_array($value)){
            $arr = array_merge($arr, $value);
        }else{
            $arr[] = $value;
        }

        $this->setShopInvoiceProformaIDs($arr);
    }

    public function setShopBankAccountID($value){
        $this->setValueInt('shop_bank_account_id', $value);
    }
    public function getShopBankAccountID(){
        return $this->getValueInt('shop_bank_account_id');
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
