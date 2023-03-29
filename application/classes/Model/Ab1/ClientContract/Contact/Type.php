<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ab1_ClientContract_Contact_Type extends Model_Shop_Table_Basic_Table{

    const TABLE_NAME = 'ab_client_contract_contact_types';
    const TABLE_ID = '';

    public function __construct(){
        parent::__construct(
            array(
			'format',
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

        $this->isValidationFieldStr('format', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setFormat($value){
        $this->setValue('format', $value);
    }
    public function getFormat(){
        return $this->getValue('format');
    }


}
