<?php defined('SYSPATH') or die('No direct script access.');


class Model_Magazine_Shop_Invoice extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'sp_shop_invoices';
	const TABLE_ID = 280;

	public function __construct(){
		parent::__construct(
			array(
                'amount',
                'quantity',
                'date',
                'date_from',
                'date_to',
                'number_esf',
                'number',
                'is_esf_receive',
                'esf_type_id',
                'shop_invoice_id',
                'is_import_esf',
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

        $this->isValidationFieldFloat('amount', $validation);
        $this->isValidationFieldFloat('quantity', $validation);
        $this->isValidationFieldBool('is_esf_receive', $validation);
        $this->isValidationFieldStr('number', $validation, 50);
        $this->isValidationFieldStr('number_esf', $validation, 50);
        $this->isValidationFieldStr('esf_type_id', $validation, 255);
        $this->isValidationFieldInt('is_import_esf', $validation);

        $this->isValidationFieldBool('is_esf_receive', $validation);
        return $this->_validationFields($validation, $errorFields);
    }

    public function setIsCalcESF($value){
        $this->setValueBool('is_calc_esf', $value);
    }
    public function getIsCalcESF(){
        return $this->getValueBool('is_calc_esf');
    }

    public function setShopInvoiceID($value){
        $this->setValueInt('shop_invoice_id', $value);
    }
    public function getShopInvoiceID(){
        return $this->getValueInt('shop_invoice_id');
    }

    public function setESFTypeID($value){
        if(is_array($value)) {
            $this->setValueArray('esf_type_id', $value, false);
        }else{
            $this->setValueInt('esf_type_id', $value);
        }
    }
    public function getESFTypeID(){
        return $this->getValueInt('esf_type_id');
    }
    public function getESFTypeIDArray(){
        return $this->getValueArray('esf_type_id', null, array(), false);
    }

    public function setNumber($value){
        $this->setValue('number', $value);
    }
    public function getNumber(){
        return $this->getValue('number');
    }

    public function setNumberESF($value){
        $this->setValue('number_esf', $value);
    }
    public function getNumberESF(){
        return $this->getValue('number_esf');
    }

    public function setQuantity($value){
        $this->setValueFloat('quantity', $value);
    }
    public function getQuantity(){
        return $this->getValueFloat('quantity');
    }

    public function setAmount($value){
        $this->setValueFloat('amount', $value);
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }

    public function setDate($value){
        $this->setValueDate('date', $value);
    }
    public function getDate(){
        return $this->getValueDate('date');
    }

    public function setESFDate($value){
        $this->setValueDate('esf_date', $value);
    }
    public function getESFDate(){
        return $this->getValueDate('esf_date');
    }

    public function setDateFrom($value){
        $this->setValueDate('date_from', $value);
    }
    public function getDateFrom(){
        return $this->getValueDate('date_from');
    }

    public function setDateTo($value){
        $this->setValueDate('date_to', $value);
    }
    public function getDateTo(){
        return $this->getValueDate('date_to');
    }

    public function setIsESFReceive($value){
        $this->setValueBool('is_esf_receive', $value);
    }
    public function getIsESFReceive(){
        return $this->getValueBool('is_esf_receive');
    }

    public function setIsImportESF($value){
        $this->setValueBool('is_import_esf', $value);
    }
    public function getIsImportESF(){
        return $this->getValueBool('is_import_esf');
    }

    // Данные ЭСФ
    public function setImportESFObject(Helpers_ESF_Unload_Invoice $value){
        $this->setValueArray('import_esf', $value->saveInArray());
    }
    public function getImportESFObject(){
        $result = new Helpers_ESF_Unload_Invoice();
        $result->loadToArray($this->getValueArray('import_esf'));
        return $result;
    }

    public function setImportESFArray(array $value){
        $this->setValueArray('import_esf', $value);
    }
    public function getImportESFArray(){
        return $this->getValueArray('import_esf');
    }

    public function setImportESF($value){
        $this->setValue('import_esf', $value);
    }
    public function getImportESF(){
        return $this->getValue('import_esf');
    }

    public function setGUID1C($value){
        $this->setValue('guid_1c', $value);
    }
    public function getGUID1C(){
        return $this->getValue('guid_1c');
    }
}
