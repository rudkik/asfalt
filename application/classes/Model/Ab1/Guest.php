<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Guest extends Model_Basic_Options{

    const TABLE_NAME = 'ab_guests';
    const TABLE_ID = 424;

    public function __construct(){
        parent::__construct(
            array(
                'iin',
                'passport_number',
                'company_name'
            ),
            self::TABLE_NAME,
            self::TABLE_ID
        );
    }

    /**
     * Проверяем поля на ошибки
     * @param array $errorFields - массив ошибок
     * @return boolean
     */
    public function validationFields(array &$errorFields)
    {
        $validation = new Validation($this->getValues());

        $this->isValidationFieldStr('passport_number', $validation, 9);
        $this->isValidationFieldStr('iin', $validation, 12);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setIIN($value){
        $this->setValue('iin', $value);
    }
    public function getIIN(){
        return $this->getValue('iin');
    }

    public function setPassportNumber($value){
        $this->setValue('passport_number', $value);
    }
    public function getPassportNumber(){
        return $this->getValue('passport_number');
    }

    public function setCompanyName($value){
        $this->setValue('company_name', $value);
    }
    public function getCompanyName(){
        return $this->getValue('company_name');
    }

}
