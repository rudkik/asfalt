<?php defined('SYSPATH') or die('No direct script access.');

class Model_AutoPart_Shop_Supplier_Parser extends Model_Shop_Table_Basic_Table{

    const TABLE_NAME = 'ap_shop_supplier_parsers';
    const TABLE_ID = '';

    public function __construct(){
        parent::__construct(
            array(
			'shop_supplier_id',
			'step',
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

        $this->isValidationFieldInt('shop_supplier_id', $validation);
        $this->isValidationFieldInt('step', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopSupplierID($value){
        $this->setValueInt('shop_supplier_id', $value);
    }
    public function getShopSupplierID(){
        return $this->getValueInt('shop_supplier_id');
    }

    public function setStep($value){
        $this->setValueInt('step', $value);
    }
    public function getStep(){
        return $this->getValueInt('step');
    }

    public function setQuantity($value){
        $this->setValueInt('quantity', $value);
    }
    public function getQuantity(){
        return $this->getValueInt('quantity');
    }

}
