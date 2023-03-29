<?php defined('SYSPATH') or die('No direct script access.');

class Model_AutoPart_Shop_Product_Join extends Model_Shop_Table_Basic_Table{

    const TABLE_NAME = 'ap_shop_product_joins';
    const TABLE_ID = '';

    public function __construct(){
        parent::__construct(
            array(
			'shop_source_id',
			'quantity',
			'shop_operation_id',
			'date',
			'shop_product_id',
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
                   case 'shop_source_id':
                            $this->_dbGetElement($this->getShopSourceID(), 'shop_source_id', new Model_AutoPart_Shop_Source(), $shopID);
                            break;
                   case 'shop_operation_id':
                            $this->_dbGetElement($this->getShopOperationID(), 'shop_operation_id', new Model_Shop_Operation(), $shopID);
                            break;
                   case 'shop_product_id':
                            $this->_dbGetElement($this->getShopProductID(), 'shop_product_id', new Model_AutoPart_Shop_Product(), $shopID);
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

        $this->isValidationFieldInt('shop_source_id', $validation);
        $this->isValidationFieldInt('quantity', $validation);
        $this->isValidationFieldInt('shop_operation_id', $validation);
        $this->isValidationField('date', $validation);
        $this->isValidationFieldInt('shop_product_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopSourceID($value){
        $this->setValueInt('shop_source_id', $value);
    }
    public function getShopSourceID(){
        return $this->getValueInt('shop_source_id');
    }

    public function setQuantity($value){
        $this->setValueInt('quantity', $value);
    }
    public function getQuantity(){
        return $this->getValueInt('quantity');
    }

    public function setShopOperationID($value){
        $this->setValueInt('shop_operation_id', $value);
    }
    public function getShopOperationID(){
        return $this->getValueInt('shop_operation_id');
    }

    public function setDate($value){
        $this->setValueDate('date', $value);
    }
    public function getDate(){
        return $this->getValueDate('date');
    }

    public function setShopProductID($value){
        $this->setValueInt('shop_product_id', $value);
    }
    public function getShopProductID(){
        return $this->getValueInt('shop_product_id');
    }


}
