<?php defined('SYSPATH') or die('No direct script access.');

class Model_AutoPart_Shop_Attribute_Rubric extends Model_Shop_Table_Basic_Table{

    const TABLE_NAME = 'ap_shop_attribute_rubrics';
    const TABLE_ID = '';

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


}
