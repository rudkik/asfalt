<?php defined('SYSPATH') or die('No direct script access.');


class Model_AutoPart_Shop_Bill_Delivery_Type extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ap_shop_bill_delivery_types';
    const TABLE_ID = 348;

    public function __construct(){
        parent::__construct(
            array(

            ),
            self::TABLE_NAME,
            self::TABLE_ID
        );

        $this->isAddCreated = TRUE;
    }

    /**
     * Проверяем поля на ошибки
     * @param array $errorFields - массив ошибок
     * @return boolean
     */
    public function validationFields(array &$errorFields)
    {
        $validation = new Validation($this->getValues());

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopSourceID($value){
        $this->setValueInt('shop_source_id', $value);
    }
    public function getShopSourceID(){
        return $this->getValueInt('shop_source_id');
    }
}
