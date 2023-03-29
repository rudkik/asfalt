<?php defined('SYSPATH') or die('No direct script access.');


class Model_AutoPart_Shop_Product_Attribute extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ap_shop_product_attributes';
    const TABLE_ID = 431;

    public function __construct(){
        parent::__construct(
            array(
                'shop_attribute_id',
                'shop_product_id',
                'shop_product_attribute_type_id',
                'shop_product_attribute_rubric_id',
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
                    case 'shop_attribute_id':
                        $this->_dbGetElement($this->getShopAttributeID(), 'shop_attribute_id', new Model_AutoPart_Shop_Attribute());
                        break;
                    case 'shop_product_id':
                        $this->_dbGetElement($this->getShopProductID(), 'shop_product_id', new Model_AutoPart_Shop_Product());
                        break;
                    case 'shop_product_attribute_type_id':
                        $this->_dbGetElement($this->getShopProductAttributeTypeID(), 'shop_product_attribute_type_id', new Model_AutoPart_Shop_Attribute_Type());
                        break;
                    case 'shop_product_attribute_rubric_id':
                        $this->_dbGetElement($this->getShopProductAttributeRubricID(), 'shop_product_attribute_rubric_id', new Model_AutoPart_Shop_Attribute_Rubric());
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
        $this->isValidationFieldInt('shop_attribute_id', $validation);
        $this->isValidationFieldInt('shop_product_id', $validation);
        $this->isValidationFieldInt('shop_product_attribute_rubric_id', $validation);
        $this->isValidationFieldInt('shop_product_attribute_type_id', $validation);

        return $this->_validationFields($validation, $errorFields);

    }
    public function setShopAttributeID($value){
        $this->setValueInt('shop_attribute_id', $value);
    }
    public function getShopAttributeID(){
        return $this->getValueInt('shop_attribute_id');
    }

    public function setShopProductID($value){
        $this->setValue('shop_product_id', $value);
    }
    public function getShopProductID(){
        return $this->getValue('shop_product_id');
    }

    public function setShopProductAttributeRubricID($value){
        $this->setValue('shop_product_attribute_rubric_id', $value);
    }
    public function getShopProductAttributeRubricID(){
        return $this->getValue('shop_product_attribute_rubric_id');
    }

    public function setShopProductAttributeTypeID($value){
        $this->setValue('shop_product_attribute_type_id', $value);
    }
    public function getShopProductAttributeTypeID(){
        return $this->getValue('shop_product_attribute_type_id');
    }


}
