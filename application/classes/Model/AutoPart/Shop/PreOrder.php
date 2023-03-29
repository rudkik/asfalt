<?php defined('SYSPATH') or die('No direct script access.');

class Model_AutoPart_Shop_PreOrder extends Model_Shop_Table_Basic_Table{

    const TABLE_NAME = 'ap_shop_pre_orders';
    const TABLE_ID = '';

    public function __construct(){
        parent::__construct(
            array(
			'is_nds',
			'date',
			'amount',
			'shop_supplier_id',
			'shop_courier_id',
			'quantity',
			'number',
			'is_buy',
			'buy_at',
			'shop_supplier_address_id',
			'is_check',
			'shop_company_id',
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
                   case 'shop_supplier_address_id':
                            $this->_dbGetElement($this->getShopSupplierAddressID(), 'shop_supplier_address_id', new Model_AutoPart_Shop_Supplier_Address(), $shopID);
                            break;
                   case 'shop_company_id':
                            $this->_dbGetElement($this->getShopCompanyID(), 'shop_company_id', new Model_AutoPart_Shop_Company(), $shopID);
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

        $validation->rule('amount', 'max_length', array(':value',13));

        $this->isValidationFieldInt('shop_supplier_id', $validation);
        $this->isValidationFieldInt('shop_courier_id', $validation);
        $validation->rule('quantity', 'max_length', array(':value',13));

        $this->isValidationFieldStr('number', $validation);
        $this->isValidationFieldBool('is_buy', $validation);
        $this->isValidationFieldInt('shop_supplier_address_id', $validation);
        $this->isValidationFieldBool('is_check', $validation);
        $this->isValidationFieldInt('shop_company_id', $validation);

        return $this->_validationFields($validation, $errorFields);
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

    public function setIsBuy($value){
        $this->setValueBool('is_buy', $value);
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

    public function setShopSupplierAddressID($value){
        $this->setValueInt('shop_supplier_address_id', $value);
    }
    public function getShopSupplierAddressID(){
        return $this->getValueInt('shop_supplier_address_id');
    }

    public function setIsCheck($value){
        $this->setValueBool('is_check', $value);
    }
    public function getIsCheck(){
        return $this->getValueBool('is_check');
    }

    public function setShopCompanyID($value){
        $this->setValueInt('shop_company_id', $value);
    }
    public function getShopCompanyID(){
        return $this->getValueInt('shop_company_id');
    }


}
