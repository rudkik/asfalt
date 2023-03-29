<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ab1_ClientContract_Kind extends Model_Shop_Table_Basic_Table{
    const CLIENT_CONTRACT_TYPE_SALE = 1; // Продажа продукции
    const CLIENT_CONTRACT_TYPE_BUY = 2; // Покупка

    const TABLE_NAME = 'ab_client_contract_kinds';
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
