<?php defined('SYSPATH') or die('No direct script access.');

class Model_AutoPart_Shop_Purchase_Product extends Model_Shop_Table_Basic_Table{

    const TABLE_NAME = 'ap_shop_purchase_products';
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
        $this->isValidationFieldFloat('amount', $validation);
        $this->isValidationFieldInt('shop_supplier_id', $validation);
        $this->isValidationFieldStr('esf', $validation);
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

    public function setEsf($value){
        $this->setValue('esf', $value);
    }
    public function getEsf(){
        return $this->getValue('esf');
    }

    public function setEsfNumber($value){
        $this->setValue('esf_number', $value);
    }
    public function getEsfNumber(){
        return $this->getValue('esf_number');
    }

    public function setEsfDate($value){
        $this->setValueDate('esf_date', $value);
    }
    public function getEsfDate(){
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


}
