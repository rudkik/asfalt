<?php defined('SYSPATH') or die('No direct script access.');

class Model_AutoPart_Shop_Product_Storage extends Model_Shop_Table_Basic_Table{

    const TABLE_NAME = 'ap_shop_product_storages';
    const TABLE_ID = '';

    public function __construct(){
        parent::__construct(
            array(
			'shop_supplier_id',
			'shop_other_address_id',
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
                   case 'shop_other_address_id':
                            $this->_dbGetElement($this->getShopOtherAddressID(), 'shop_other_address_id', new Model_AutoPart_Shop_Other_Address(), $shopID);
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
        $this->isValidationFieldInt('shop_other_address_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopSupplierID($value){
        $this->setValueInt('shop_supplier_id', $value);
    }
    public function getShopSupplierID(){
        return $this->getValueInt('shop_supplier_id');
    }

    public function setShopOtherAddressID($value){
        $this->setValueInt('shop_other_address_id', $value);
    }
    public function getShopOtherAddressID(){
        return $this->getValueInt('shop_other_address_id');
    }


}
