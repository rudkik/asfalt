<?php defined('SYSPATH') or die('No direct script access.');

class Model_AutoPart_Shop_Receive extends Model_Shop_Table_Basic_Table{

    const TABLE_NAME = 'ap_shop_receives';
    const TABLE_ID = '';

    public function __construct(){
        parent::__construct(
            array(
			'is_nds',
			'date',
			'amount',
			'shop_supplier_id',
			'esf',
			'esf_number',
			'esf_date',
			'shop_courier_id',
			'quantity',
			'number',
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
                            $this->_dbGetElement($this->getShopSupplierID(), 'shop_supplier_id', new Model_AutoPart_Shop_Supplier(), $shopID);
                            break;
                   case 'shop_courier_id':
                            $this->_dbGetElement($this->getShopCourierID(), 'shop_courier_id', new Model_AutoPart_Shop_Courier(), $shopID);
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

        $this->isValidationFieldBool('is_nds', $validation);
        $validation->rule('amount', 'max_length', array(':value',13));

        $this->isValidationFieldInt('shop_supplier_id', $validation);
        $this->isValidationFieldStr('esf_number', $validation);
        $this->isValidationFieldInt('shop_courier_id', $validation);
        $validation->rule('quantity', 'max_length', array(':value',13));

        $this->isValidationFieldStr('number', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setIsNds($value){
        $this->setValueBool('is_nds', $value);
    }
    public function getIsNds(){
        return $this->getValueBool('is_nds');
    }

    public function setDate($value){
        $this->setValueDate('date', $value);
    }
    public function getDate(){
        return $this->getValueDate('date');
    }

    public function setAmount($value){
        $this->setValueFloat('amount', $value);
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }

    public function setShopSupplierID($value){
        $this->setValueInt('shop_supplier_id', $value);
    }
    public function getShopSupplierID(){
        return $this->getValueInt('shop_supplier_id');
    }

    public function setShopCompanyID($value){
        $this->setValueInt('shop_company_id', $value);
    }
    public function getShopCompanyID(){
        return $this->getValueInt('shop_company_id');
    }

    public function setESFNumber($value){
        $this->setValue('esf_number', $value);
    }
    public function getESFNumber(){
        return $this->getValue('esf_number');
    }

    public function setESFDate($value){
        $this->setValueDate('esf_date', $value);
    }
    public function getESFDate(){
        return $this->getValueDate('esf_date');
    }

    public function setShopCourierID($value){
        $this->setValueInt('shop_courier_id', $value);
    }
    public function getShopCourierID(){
        return $this->getValueInt('shop_courier_id');
    }

    public function setQuantity($value){
        $this->setValueFloat('quantity', $value);
    }
    public function getQuantity(){
        return $this->getValueFloat('quantity');
    }

    public function setNumber($value){
        $this->setValue('number', $value);
    }
    public function getNumber(){
        return $this->getValue('number');
    }

    public function setShopSupplierAddressID($value){
        $this->setValueInt('shop_supplier_address_id', $value);
    }
    public function getShopSupplierAddressID(){
        return $this->getValueInt('shop_supplier_address_id');
    }

    public function setIsBuy($value){
        $this->setValueBool('is_buy', $value);

        if($this->getIsBuy()){
            $this->setBuyAt(Helpers_DateTime::getCurrentDateTimePHP());
        }else{
            $this->setBuyAt(null);
        }
    }
    public function getIsBuy(){
        return $this->getValueBool('is_buy');
    }

    public function setBuyAt($value){
        $this->setValueDateTime('buy_at', $value);
    }
    public function getBuyAt(){
        return $this->getValueDateTime('buy_at');
    }


    // Данные ЭСФ
    public function setESFObject(Helpers_ESF_Unload_Invoice $value){
        $this->setValueArray('esf', $value->saveInArray());

        if($this->getESF() !== NULL) {
            if ($this->getESFDate() == NULL) {
                $this->setESFDate(date('Y-m-d H:i:s'));
            }

            $this->setIsLoadFile(true);
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

    public function setIsCheck($value){
        $this->setValueBool('is_check', $value);
    }
    public function getIsCheck(){
        return $this->getValueBool('is_check');
    }

    public function setIsStore($value){
        $this->setValueBool('is_store', $value);
    }
    public function getIsStore(){
        return $this->getValueBool('is_store');
    }

    public function setIsLoadFile($value){
        $this->setValueBool('is_load_file', $value);
    }
    public function getIsLoadFile(){
        return $this->getValueBool('is_load_file');
    }

    public function setIsReturn($value){
        $this->setValueBool('is_return', $value);
    }
    public function getIsReturn(){
        return $this->getValueBool('is_return');
    }

    public function setReturnShopReceiveID($value){
        $this->setValueInt('return_shop_receive_id', $value);
    }
    public function getReturnShopReceiveID(){
        return $this->getValueInt('return_shop_receive_id');
    }
}
