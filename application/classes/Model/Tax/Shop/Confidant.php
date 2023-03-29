<?php defined('SYSPATH') or die('No direct script access.');


class Model_Tax_Shop_Confidant extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'tax_shop_confidants';
	const TABLE_ID = 98;

	public function __construct(){
		parent::__construct(
			array(
                'passport_date',
                'passport_number',
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
        $validation->rule('passport_number', 'max_length', array(':value', 50))
            ->rule('passport_issued', 'max_length', array(':value', 50))
			->rule('name_d', 'max_length', array(':value', 250));

        return $this->_validationFields($validation, $errorFields);
    }

    public function setPassportNumber($value){
        $this->setValue('passport_number', $value);
    }
    public function getPassportNumber(){
        return $this->getValue('passport_number');
    }

    public function setPassportIssued($value){
        $this->setValue('passport_issued', $value);
    }
    public function getPassportIssued(){
        return $this->getValue('passport_issued');
    }

    public function setPassportDate($value){
        $this->setValueDate('passport_date', $value);
    }
    public function getPassportDate(){
        return $this->getValue('passport_date');
    }

    public function setNameD($value){
        $this->setValue('name_d', $value);
    }
    public function getNameD(){
        return $this->getValue('name_d');
    }
}
