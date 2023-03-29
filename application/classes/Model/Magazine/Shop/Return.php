<?php defined('SYSPATH') or die('No direct script access.');


class Model_Magazine_Shop_Return extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'sp_shop_returns';
	const TABLE_ID = 260;

	public function __construct(){
		parent::__construct(
			array(
                'amount',
                'quantity',
                'is_esf',
                'esf',
                'esf_date',
                'esf_type_id',
                'esf_number',
                'number',
                'is_nds',
                'date',
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
        if(($elements !== NULL) && (is_array($elements))){
            foreach($elements as $element){
                switch($element){
                    case 'shop_supplier_id':
                        $this->_dbGetElement($this->getShopSupplierID(), 'shop_supplier_id', new Model_Magazine_Shop_Supplier(), $shopID);
                        break;
                    case 'esf_type_id':
                        $this->_dbGetElement($this->getESFTypeID(), 'esf_type_id', new Model_Magazine_ESFType());
                        break;
                }
            }
        }

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
        $this->isValidationFieldInt('shop_supplier_id', $validation);
        $this->isValidationFieldBool('is_esf', $validation);
        $this->isValidationFieldBool('is_nds', $validation);
        $this->isValidationFieldInt('esf_type_id', $validation);
        $this->isValidationFieldStr('esf_number', $validation, 50);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setNumber($value){
        $this->setValue('number', $value);
    }
    public function getNumber(){
        return $this->getValue('number');
    }

    public function setShopSupplierID($value){
        $this->setValueInt('shop_supplier_id', $value);
    }
    public function getShopSupplierID(){
        return $this->getValueInt('shop_supplier_id');
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

    /**
     * Возвращаем сумму без НДС
     * @return float|int
     */
    public function getAmountWithoutNDS(){
        return Api_Tax_NDS::getAmountWithoutNDS($this->getAmount(),$this->getIsNDS());
    }

    /**
     * Возвращем сумму НДС
     * @return float|int
     */
    public function getAmountNDS(){
        return Api_Tax_NDS::getAmountNDS($this->getAmount(),$this->getIsNDS());
    }

    public function setIsNDS($value){
        $this->setValueBool('is_nds', $value);
    }
    public function getIsNDS(){
        return $this->getValueBool('is_nds');
    }

    public function setESFNumberID($value){
        $this->setValue('esf_number', $value);
    }
    public function getESFNumberID(){
        return $this->getValue('esf_number');
    }

    public function setESFTypeID($value){
        $this->setValueInt('esf_type_id', $value);
    }
    public function getESFTypeID(){
        return $this->getValueInt('esf_type_id');
    }

    public function setIsESF($value){
        $this->setValueBool('is_esf', $value);
    }
    public function getIsESF(){
        return $this->getValueBool('is_esf');
    }

    // Данные ЭСФ
    public function setESFObject(Helpers_ESF_Unload_Invoice $value){
        $this->setValueArray('esf', $value->saveInArray());

        if($this->getESF() !== NULL) {
            $this->setESFTypeID(Model_Magazine_ESFType::ESF_TYPE_ELECTRONIC);

            if ($this->getESFDate() == NULL) {
                $this->setESFDate(date('Y-m-d H:i:s'));
            }
        }
    }
    public function getESFObject(){
        $result = new Helpers_ESF_Unload_Invoice();
        $result->loadToArray($this->getValueArray('esf'));
        return $result;
    }

    public function setESFArray(array $value){
        $this->setValueArray('esf', $value);

        if($this->getESF() !== NULL && $this->getESFDate() == NULL) {
            $this->setESFDate(date('Y-m-d H:i:s'));
        }
    }
    public function getESFArray(){
        return $this->getValueArray('esf');
    }

    public function setESF($value){
        $this->setValue('esf', $value);

        if($this->getESF() !== NULL && $this->getESFDate() == NULL) {
            $this->setESFDate(date('Y-m-d H:i:s'));
        }
    }
    public function getESF(){
        return $this->getValue('esf');
    }

    /**
     * Регистрационный номер ЭЛЕКТРОННОЙ ЭСФ
     * @return string
     */
    public function getESFRegistrationNumber(){
        if(Func::_empty($this->getESF())){
            return '';
        }else{
            return $this->getESFObject()->getRegistrationNumber();
        }

    }

    public function setESFDate($value){
        $this->setValueDateTime('esf_date', $value);
    }
    public function getESFDate(){
        return $this->getValueDateTime('esf_date');
    }

    public function setDate($value){
        $this->setValueDate('date', $value);
    }
    public function getDate(){
        return $this->getValueDate('date');
    }

    public function setESFNumber($value){
        $this->setValue('esf_number', $value);
    }
    public function getESFNumber(){
        return $this->getValue('esf_number');
    }

    public function setGUID1C($value){
        $this->setValue('guid_1c', $value);
    }
    public function getGUID1C(){
        return $this->getValue('guid_1c');
    }
}
