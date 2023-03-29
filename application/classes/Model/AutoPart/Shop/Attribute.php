<?php defined('SYSPATH') or die('No direct script access.');


class Model_AutoPart_Shop_Attribute extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ap_shop_attributes';
    const TABLE_ID = 430;

    public function __construct(){
        parent::__construct(
            array(
                'shop_attribute_type_id',
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
                    case 'shop_attribute_type_id':
                        $this->_dbGetElement($this->getShopAttributeTypeID(), 'shop_attribute_type_id', new Model_AutoPart_Shop_Attribute());
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
        $this->isValidationFieldInt('shop_attribute_type_id', $validation);

        return $this->_validationFields($validation, $errorFields);

    }
    public function setShopAttributeTypeID($value){
        $this->setValueInt('shop_attribute_type_id', $value);
    }
    public function getShopAttributeTypeID(){
        return $this->getValueInt('shop_attribute_type_id');
    }

}
